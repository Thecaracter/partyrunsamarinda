<?php

namespace App\Http\Controllers\User;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Size;
use App\Models\Peserta;
use Midtrans\Notification;
use Illuminate\Http\Request;
use App\Mail\PaymentNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.current_server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function show($id)
    {
        try {
            $peserta = Peserta::findOrFail($id);

            if ($peserta->status_pembayaran === 'paid') {
                \Session::flash('message', 'Pembayaran sudah dilakukan');
                return redirect()->route('check-order.index', ['kode_bib' => $peserta->kode_bib]);
            }

            if (in_array($peserta->status_pembayaran, ['expired', 'failed'])) {
                $peserta->update(['status_pembayaran' => 'pending']);
            }



            $expiry = [
                'start_time' => date('Y-m-d H:i:s O'),
                'unit' => 'minute',
                'duration' => 5
            ];

            $params = [
                'transaction_details' => [
                    'order_id' => 'REG-' . $peserta->id . '-' . time(),
                    'gross_amount' => (int) $peserta->amount,
                ],
                'customer_details' => [
                    'first_name' => $peserta->nama_lengkap,
                    'email' => $peserta->email,
                    'phone' => $peserta->no_wa,
                ],
                'item_details' => [
                    [
                        'id' => 'REG-FEE',
                        'price' => (int) $peserta->amount,
                        'quantity' => 1,
                        'name' => 'Biaya Pendaftaran Party Color Run',
                        'category' => $peserta->kategori
                    ]
                ],
                'expiry' => $expiry
            ];

            $snapToken = Snap::getSnapToken($params);
            return view('user.payment.show', compact('peserta', 'snapToken'));

        } catch (\Exception $e) {
            \Log::error('Kesalahan Midtrans:', [
                'pesan' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            \Session::flash('error', 'Terjadi kesalahan saat memproses pembayaran');
            return redirect()->route('check-order.index');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $peserta = Peserta::findOrFail($id);
            $oldStatus = $peserta->status_pembayaran;

            $status = match ($request->transaction_status) {
                'capture', 'settlement' => 'paid',
                'pending' => 'pending',
                'deny', 'cancel' => 'failed',
                'expire' => 'expired',
                default => 'failed'
            };

            $peserta->update([
                'status_pembayaran' => $status,
                'payment_date' => now(),
                'midtrans_transaction_id' => $request->transaction_id ?? null,
                'midtrans_payment_type' => $request->payment_type ?? null,
                'amount' => $request->gross_amount ?? $peserta->amount
            ]);

            if ($status === 'paid' && $oldStatus !== 'paid') {
                try {
                    Mail::to($peserta->email)->send(new PaymentNotification($peserta));
                } catch (\Exception $e) {
                    \Log::error('Error mengirim email:', [
                        'peserta_id' => $peserta->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status pembayaran berhasil diperbarui',
                'redirect' => route('check-order.index', ['kode_bib' => $peserta->kode_bib])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Kesalahan Update Status Pembayaran:', [
                'pesan' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui status pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    public function notification()
    {
        try {
            // Log raw notification untuk debugging
            \Log::info('Raw Notification:', request()->all());

            DB::beginTransaction();

            // Ambil data dari request langsung, bukan dari Notification class
            $order_id = request('order_id');
            $transaction_status = request('transaction_status');
            $transaction_id = request('transaction_id');
            $payment_type = request('payment_type');
            $gross_amount = request('gross_amount');

            // Extract peserta_id dari order_id
            $peserta_id = explode('-', $order_id)[1] ?? null;

            if (!$peserta_id) {
                \Log::error('Invalid order_id format:', ['order_id' => $order_id]);
                return response()->json(['message' => 'Invalid order ID format'], 400);
            }

            $peserta = Peserta::find($peserta_id);

            if (!$peserta) {
                \Log::error('Peserta tidak ditemukan:', ['order_id' => $order_id, 'peserta_id' => $peserta_id]);
                return response()->json(['message' => 'Peserta tidak ditemukan'], 404);
            }

            $oldStatus = $peserta->status_pembayaran;

            $status = match ($transaction_status) {
                'capture', 'settlement' => 'paid',
                'pending' => 'pending',
                'deny', 'cancel' => 'failed',
                'expire' => 'expired',
                default => 'failed'
            };

            \Log::info('Updating payment status:', [
                'peserta_id' => $peserta->id,
                'old_status' => $oldStatus,
                'new_status' => $status,
                'transaction_id' => $transaction_id
            ]);

            $peserta->update([
                'status_pembayaran' => $status,
                'payment_date' => now(),
                'midtrans_transaction_id' => $transaction_id,
                'midtrans_payment_type' => $payment_type,
                'amount' => $gross_amount
            ]);

            if ($status === 'paid' && $oldStatus !== 'paid') {
                try {
                    Mail::to($peserta->email)->send(new PaymentNotification($peserta));
                } catch (\Exception $e) {
                    \Log::error('Error mengirim email:', [
                        'peserta_id' => $peserta->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            DB::commit();
            return response()->json(['message' => 'Notifikasi berhasil diproses']);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Kesalahan Notifikasi:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => request()->all()
            ]);
            return response()->json(['message' => 'Gagal memproses notifikasi'], 500);
        }
    }

    public function finish(Request $request)
    {
        \Session::flash('success', 'Pembayaran berhasil! Terima kasih telah mendaftar.');
        return redirect()->route('check-order.index');
    }

    public function unfinish(Request $request)
    {
        \Session::flash('warning', 'Pembayaran belum selesai. Silakan coba lagi.');
        return redirect()->route('check-order.index');
    }

    public function error(Request $request)
    {
        \Session::flash('error', 'Terjadi kesalahan dalam pembayaran. Silakan coba lagi.');
        return redirect()->route('check-order.index');
    }
}