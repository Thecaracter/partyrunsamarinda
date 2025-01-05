<?php

namespace App\Http\Controllers;

use App\Mail\PaymentNotification;
use App\Models\Peserta;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function showEmailDashboard(Request $request)
    {
        $search = $request->input('search');

        $query = Peserta::whereNotNull('kode_bib')
            ->where('status_pembayaran', 'paid');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('kode_bib', 'like', "%{$search}%");
            });
        }

        $pesertaDenganBib = $query->get();

        return view('emails.dashboard', compact('pesertaDenganBib', 'search'));
    }

    // method lainnya tetap sama
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
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'log' => [
                    'email' => $peserta->email ?? 'unknown'
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
            foreach ($pesertaList as $peserta) {
                try {
                    Mail::to($peserta->email)->send(new PaymentNotification($peserta));
                    $log = [
                        'status' => 'success',
                        'email' => $peserta->email
                    ];
                } catch (\Exception $e) {
                    $log = [
                        'status' => 'failed',
                        'email' => $peserta->email
                    ];
                }

                echo "data: " . json_encode($log) . "\n\n";
                ob_flush();
                flush();
                usleep(100000);
            }
        }, 200, [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'text/event-stream',
            'X-Accel-Buffering' => 'no'
        ]);
    }
}