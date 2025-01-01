<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\PesertaExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function exportExcel()
    {
        return Excel::download(
            new PesertaExport,
            'data_peserta_party_run_' . now()->format('Y-m-d_His') . '.xlsx'
        );
    }
}