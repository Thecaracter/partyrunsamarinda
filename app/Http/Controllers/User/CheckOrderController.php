<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use Illuminate\Http\Request;

class CheckOrderController extends Controller
{
    public function index()
    {
        $peserta = null;
        if (request('kode_bib')) {
            $peserta = Peserta::where('kode_bib', request('kode_bib'))->first();
            if (!$peserta) {
                return back()->with('error', 'Kode BIB tidak ditemukan');
            }
        }
        return view('user.check-order', compact('peserta'));
    }
}