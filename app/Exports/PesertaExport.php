<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PesertaExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Data Peserta' => new PesertaDataSheet(),
            'Analisis' => new PesertaAnalysisSheet(),
        ];
    }
}