<?php

namespace App\Http\Controllers;

use App\Mail\PaymentNotification;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Exception;

class EmailController extends Controller
{
    public function showEmailDashboard(Request $request)
    {
        $search = $request->input('search');
        $perPage = 2;

        $query = Peserta::whereNotNull('kode_bib')
            ->where('status_pembayaran', 'paid');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('kode_bib', 'like', "%{$search}%");
            });
        }

        $pesertaDenganBib = $query->paginate($perPage);

        return view('emails.dashboard', compact('pesertaDenganBib', 'search'));
    }

    public function sendSingleEmail(Request $request)
    {
        $request->validate([
            'peserta_id' => 'required|exists:peserta,id'
        ]);

        try {
            $peserta = Peserta::findOrFail($request->peserta_id);
            Mail::to($peserta->email)->send(new PaymentNotification($peserta));

            return response()->json([
                'success' => true,
                'log' => [
                    'email' => $peserta->email
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'log' => [
                    'email' => $peserta->email ?? 'unknown',
                    'error' => $this->getMailTransportError($e)
                ]
            ], 500);
        }
    }

    public function blastEmails(Request $request)
    {
        // Ambil parameter page dan search dari request
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $perPage = 2;

        // Buat query dasar
        $query = Peserta::whereNotNull('kode_bib')
            ->where('status_pembayaran', 'paid');

        // Tambahkan filter pencarian jika ada
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('kode_bib', 'like', "%{$search}%");
            });
        }

        // Ambil data sesuai halaman yang aktif
        $pesertaList = $query->paginate($perPage)->items();

        \Log::info("Starting email blast for " . count($pesertaList) . " recipients from page " . $page);

        return response()->stream(function () use ($pesertaList) {
            $totalSent = 0;
            $totalToSend = count($pesertaList);

            foreach ($pesertaList as $index => $peserta) {
                if (connection_aborted()) {
                    \Log::info("Connection aborted");
                    return;
                }

                try {
                    \Log::info("Attempting to send email to: " . $peserta->email);
                    Mail::to($peserta->email)->send(new PaymentNotification($peserta));
                    \Log::info("Email sent successfully to: " . $peserta->email);
                    $totalSent++;
                    $log = [
                        'status' => 'success',
                        'email' => $peserta->email,
                        'nama' => $peserta->nama_lengkap,
                        'kode_bib' => $peserta->kode_bib,
                        'totalSent' => $totalSent,
                        'remaining' => $totalToSend - $totalSent,
                        'percentage' => round(($totalSent / $totalToSend) * 100)
                    ];
                } catch (Exception $e) {
                    \Log::error("Failed sending to {$peserta->email}: " . $e->getMessage());
                    $log = [
                        'status' => 'failed',
                        'email' => $peserta->email,
                        'nama' => $peserta->nama_lengkap,
                        'kode_bib' => $peserta->kode_bib,
                        'error' => $this->getMailTransportError($e),
                        'totalSent' => $totalSent,
                        'remaining' => $totalToSend - $totalSent,
                        'percentage' => round(($totalSent / $totalToSend) * 100)
                    ];
                }

                echo "data: " . json_encode($log) . "\n\n";
                ob_flush();
                flush();
                usleep(300000); // 300ms delay antar email
            }

            // Send completion message
            $log = [
                'status' => 'completed',
                'message' => "Pengiriman email selesai",
                'totalSent' => $totalSent,
                'totalFailed' => $totalToSend - $totalSent
            ];
            echo "data: " . json_encode($log) . "\n\n";
            ob_flush();
            flush();

        }, 200, [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'text/event-stream',
            'X-Accel-Buffering' => 'no'
        ]);
    }

    private function getMailTransportError(Exception $e)
    {
        $message = $e->getMessage();

        if (str_contains($message, 'Connection could not be established')) {
            return 'Gagal terhubung ke server SMTP. Periksa konfigurasi email.';
        }

        if (str_contains($message, 'Connection timed out')) {
            return 'Koneksi ke server SMTP timeout. Coba lagi nanti.';
        }

        if (str_contains($message, 'Failed to authenticate')) {
            return 'Gagal autentikasi SMTP. Periksa username/password email.';
        }

        if (str_contains($message, 'Invalid address')) {
            return 'Alamat email tidak valid.';
        }

        if (str_contains($message, 'Mailbox unavailable')) {
            return 'Email tujuan tidak tersedia atau tidak aktif.';
        }

        if (str_contains($message, 'Quota exceeded')) {
            return 'Kuota email sudah terlampaui.';
        }

        if (str_contains($message, 'Rate limit exceeded')) {
            return 'Batas pengiriman email tercapai. Coba lagi nanti.';
        }

        return 'Error pengiriman email: ' . $message;
    }
}