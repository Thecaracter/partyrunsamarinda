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
        if (request('no_wa') && request('email')) {
            $peserta = Peserta::where('no_wa', request('no_wa'))
                ->where('email', request('email'))
                ->first();
            if (!$peserta) {
                return back()->with('error', 'Nomor WhatsApp tidak ditemukan');
            }
        }
        return view('user.check-order', compact('peserta'));
    }
}