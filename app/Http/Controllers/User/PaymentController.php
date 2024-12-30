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
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function show($id)
    {
        try {
            $peserta = Peserta::findOrFail($id);

            // Cek status pembayaran
            if ($peserta->status_pembayaran === 'paid') {
                \Session::flash('message', 'Pembayaran sudah dilakukan');
                return redirect()->route('check-order.index', ['kode_bib' => $peserta->kode_bib]);
            }

            // Cek jika status expired/failed, reset status ke pending
            if (in_array($peserta->status_pembayaran, ['expired', 'failed'])) {
                $peserta->update(['status_pembayaran' => 'pending']);
            }

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

            // Konversi status dari Midtrans ke status aplikasi
            $status = match ($request->transaction_status) {
                'capture', 'settlement' => 'paid',
                'pending' => 'pending',
                'deny', 'cancel' => 'failed',
                'expire' => 'expired',
                default => 'failed'
            };

            // Update data peserta
            $peserta->update([
                'status_pembayaran' => $status,
                'payment_date' => now(),
                'midtrans_transaction_id' => $request->transaction_id ?? null,
                'midtrans_payment_type' => $request->payment_type ?? null,
                'amount' => $request->gross_amount ?? $peserta->amount
            ]);

            // Jika pembayaran berhasil dan status sebelumnya bukan paid
            if ($status === 'paid' && $oldStatus !== 'paid') {
                // Generate BIB jika belum ada
                if (empty($peserta->kode_bib)) {
                    $this->generateBibNumber($peserta);
                }

                // Kurangi stok size
                $size = Size::find($peserta->size_id);
                if ($size) {
                    if ($size->stock > 0) {
                        $size->decrement('stock');
                    } else {
                        throw new \Exception('Stok jersey untuk ukuran yang dipilih sudah habis');
                    }
                }

                // Kirim email notifikasi
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
            DB::beginTransaction();

            $notifikasi = new Notification();

            // Ambil ID peserta dari order_id (format: REG-{id}-{timestamp})
            $peserta_id = explode('-', $notifikasi->order_id)[1];
            $peserta = Peserta::find($peserta_id);

            if (!$peserta) {
                \Log::error('Peserta tidak ditemukan:', ['order_id' => $notifikasi->order_id]);
                return response()->json(['message' => 'Peserta tidak ditemukan'], 404);
            }

            $oldStatus = $peserta->status_pembayaran;

            // Konversi status Midtrans ke status aplikasi
            $status = match ($notifikasi->transaction_status) {
                'capture', 'settlement' => 'paid',
                'pending' => 'pending',
                'deny', 'cancel' => 'failed',
                'expire' => 'expired',
                default => 'failed'
            };

            // Update data peserta
            $peserta->update([
                'status_pembayaran' => $status,
                'payment_date' => now(),
                'midtrans_transaction_id' => $notifikasi->transaction_id,
                'midtrans_payment_type' => $notifikasi->payment_type,
                'amount' => $notifikasi->gross_amount
            ]);

            // Jika pembayaran berhasil dan status sebelumnya bukan paid
            if ($status === 'paid' && $oldStatus !== 'paid') {
                // Generate BIB jika belum ada
                if (empty($peserta->kode_bib)) {
                    $this->generateBibNumber($peserta);
                }

                // Kurangi stok size
                $size = Size::find($peserta->size_id);
                if ($size) {
                    if ($size->stock > 0) {
                        $size->decrement('stock');
                    } else {
                        throw new \Exception('Stok jersey untuk ukuran yang dipilih sudah habis');
                    }
                }

                // Kirim email notifikasi
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
            \Log::error('Kesalahan Notifikasi Midtrans:', [
                'pesan' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'Gagal memproses notifikasi: ' . $e->getMessage()], 500);
        }
    }

    protected function generateBibNumber($peserta)
    {
        // Format: PCR-KATEGORI-NOMOR
        $prefix = 'PCR-' . substr(strtoupper($peserta->kategori), 0, 1);
        $lastBib = Peserta::where('kode_bib', 'like', $prefix . '%')
            ->orderBy('kode_bib', 'desc')
            ->first();

        if ($lastBib) {
            $lastNumber = (int) substr($lastBib->kode_bib, -3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        $peserta->update([
            'kode_bib' => $prefix . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT)
        ]);
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