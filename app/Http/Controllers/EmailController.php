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
        $perPage = 10;

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

    public function blastEmails()
    {
        $pesertaList = Peserta::whereNotNull('kode_bib')
            ->where('status_pembayaran', 'paid')
            ->get();

        return response()->stream(function () use ($pesertaList) {
            $totalSent = 0;

            foreach ($pesertaList as $index => $peserta) {
                if (connection_aborted()) {
                    return;
                }

                if ($totalSent > 0 && $totalSent % 100 === 0) {
                    $log = [
                        'status' => 'pause',
                        'message' => "Jeda 3 menit setelah mengirim $totalSent email...",
                        'totalSent' => $totalSent,
                        'remaining' => count($pesertaList) - $totalSent
                    ];
                    echo "data: " . json_encode($log) . "\n\n";
                    ob_flush();
                    flush();
                    sleep(180);
                }

                try {
                    Mail::to($peserta->email)->send(new PaymentNotification($peserta));
                    $totalSent++;
                    $log = [
                        'status' => 'success',
                        'email' => $peserta->email,
                        'totalSent' => $totalSent,
                        'remaining' => count($pesertaList) - $totalSent
                    ];
                } catch (Exception $e) {
                    $log = [
                        'status' => 'failed',
                        'email' => $peserta->email,
                        'error' => $this->getMailTransportError($e),
                        'totalSent' => $totalSent,
                        'remaining' => count($pesertaList) - $totalSent
                    ];
                }

                echo "data: " . json_encode($log) . "\n\n";
                ob_flush();
                flush();
                usleep(600000);
            }
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