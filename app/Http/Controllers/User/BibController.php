<?php

namespace App\Http\Controllers\User;

use App\Models\Peserta;
use App\Http\Controllers\Controller;

class BibController extends Controller
{
    public function show(Peserta $peserta)
    {
        if ($peserta->status_pembayaran !== 'paid') {
            return redirect()
                ->route('check-order.index')
                ->with('error', 'Selesaikan pembayaran terlebih dahulu.');
        }

        return view('user.bib.show', compact('peserta'));
    }
}