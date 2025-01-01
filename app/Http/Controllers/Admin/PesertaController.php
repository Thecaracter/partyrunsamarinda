<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesertaController extends Controller
{
    /**
     * Display a listing of participants
     */
    public function index()
    {
        $checkedInPeserta = Peserta::with('size')
            ->where('is_checked_in', true)
            ->latest('check_in_time')
            ->get();

        $notCheckedInPeserta = Peserta::with('size')
            ->where('is_checked_in', false)
            ->where('status_pembayaran', 'paid')
            ->latest()
            ->get();

        return view('admin.peserta', compact('checkedInPeserta', 'notCheckedInPeserta'));
    }

    /**
     * Get participant data by BIB number
     */
    public function getPeserta($bibNumber)
    {
        $peserta = Peserta::with('size')
            ->where('kode_bib', $bibNumber)
            ->first();

        if (!$peserta) {
            return response()->json([
                'success' => false,
                'message' => 'Peserta dengan nomor BIB ini tidak ditemukan.'
            ], 404);
        }

        if ($peserta->status_pembayaran !== 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Peserta belum melakukan pembayaran.'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data peserta ditemukan.',
            'already_checked_in' => $peserta->is_checked_in,
            ...$peserta->toArray()
        ]);
    }

    /**
     * Process BIB number scan for check-in
     */
    public function scanBib(Request $request)
    {
        // Validate the request
        $request->validate([
            'kode_bib' => 'required|string'
        ]);

        // Find participant by BIB code
        $peserta = Peserta::where('kode_bib', $request->kode_bib)->first();

        if (!$peserta) {
            return response()->json([
                'success' => false,
                'message' => 'Peserta dengan nomor BIB ini tidak ditemukan.'
            ], 404);
        }

        // Check if already checked in
        if ($peserta->is_checked_in) {
            return response()->json([
                'success' => false,
                'message' => 'Peserta sudah melakukan check-in sebelumnya pada ' . $peserta->check_in_time->format('d M Y H:i:s')
            ], 400);
        }

        // Check if payment status is paid
        if ($peserta->status_pembayaran !== 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Peserta belum melakukan pembayaran.'
            ], 400);
        }

        // Process check-in
        $peserta->update([
            'is_checked_in' => true,
            'check_in_time' => now(),
            'checked_in_by' => Auth::id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil!',
            'data' => [
                'nama' => $peserta->nama_lengkap,
                'kode_bib' => $peserta->kode_bib,
                'kategori' => $peserta->kategori,
                'check_in_time' => $peserta->check_in_time->format('d M Y H:i:s')
            ]
        ]);
    }
    public function getPesertaData()
    {
        $checkedIn = Peserta::with('size')
            ->where('is_checked_in', true)
            ->latest('check_in_time')
            ->get();

        $notCheckedIn = Peserta::with('size')
            ->where('is_checked_in', false)
            ->where('status_pembayaran', 'paid')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'checkedIn' => $checkedIn,
            'notCheckedIn' => $notCheckedIn
        ]);
    }
}