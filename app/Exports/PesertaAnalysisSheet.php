<?php

namespace App\Exports;

use App\Models\Peserta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Support\Facades\DB;

class PesertaAnalysisSheet implements FromCollection, WithTitle, WithStyles
{
    public function collection()
    {
        // Total peserta untuk persentase
        $totalPeserta = Peserta::count();

        // Analisis Kategori
        $kategoriCount = Peserta::groupBy('kategori')
            ->select('kategori', DB::raw('count(*) as total'))
            ->get();

        // Analisis Ukuran Baju
        $sizeCount = Peserta::join('sizes', 'sizes.id', '=', 'peserta.size_id')
            ->groupBy('sizes.name')
            ->select('sizes.name', DB::raw('count(*) as total'))
            ->get();

        // Analisis Status Pembayaran
        $paymentCount = Peserta::groupBy('status_pembayaran')
            ->select('status_pembayaran', DB::raw('count(*) as total'))
            ->get();

        // Analisis Usia dengan Collection
        $ageGroups = collect([
            '< 20 tahun' => Peserta::where('usia', '<', 20)->count(),
            '20-30 tahun' => Peserta::whereBetween('usia', [20, 30])->count(),
            '31-40 tahun' => Peserta::whereBetween('usia', [31, 40])->count(),
            '41-50 tahun' => Peserta::whereBetween('usia', [41, 50])->count(),
            '> 50 tahun' => Peserta::where('usia', '>', 50)->count(),
        ])->map(function ($value, $key) {
            return [
                'range' => $key,
                'total' => $value
            ];
        })->values();

        // Analisis Provinsi (Top 10)
        $provinsiCount = Peserta::groupBy('provinsi')
            ->select('provinsi', DB::raw('count(*) as total'))
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return collect([
            ['LAPORAN ANALISIS DATA PESERTA PARTY RUN'],
            ['Tanggal: ' . now()->format('d F Y H:i:s')],
            ['Total Peserta: ' . $totalPeserta],
            [''],

            ['A. KATEGORI PESERTA'],
            ['No', 'Kategori', 'Jumlah', 'Persentase'],
            ...$kategoriCount->map(fn($item, $index) => [
                $index + 1,
                $item->kategori,
                $item->total,
                number_format(($item->total / $totalPeserta) * 100, 1) . '%'
            ]),
            [''],

            ['B. UKURAN BAJU'],
            ['No', 'Ukuran', 'Jumlah', 'Persentase'],
            ...$sizeCount->map(fn($item, $index) => [
                $index + 1,
                $item->name,
                $item->total,
                number_format(($item->total / $totalPeserta) * 100, 1) . '%'
            ]),
            [''],

            ['C. STATUS PEMBAYARAN'],
            ['No', 'Status', 'Jumlah', 'Persentase'],
            ...$paymentCount->map(fn($item, $index) => [
                $index + 1,
                ucfirst($item->status_pembayaran),
                $item->total,
                number_format(($item->total / $totalPeserta) * 100, 1) . '%'
            ]),
            [''],

            ['D. RENTANG USIA'],
            ['No', 'Rentang', 'Jumlah', 'Persentase'],
            ...$ageGroups->map(fn($item, $index) => [
                $index + 1,
                $item['range'],
                $item['total'],
                number_format(($item['total'] / $totalPeserta) * 100, 1) . '%'
            ]),
            [''],

            ['E. TOP 10 PROVINSI'],
            ['No', 'Provinsi', 'Jumlah', 'Persentase'],
            ...$provinsiCount->map(fn($item, $index) => [
                $index + 1,
                $item->provinsi,
                $item->total,
                number_format(($item->total / $totalPeserta) * 100, 1) . '%'
            ]),
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);

        // Style array for headers
        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'E9D5FF']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
            ]
        ];

        $titleStyle = [
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'DDD6FE']
            ]
        ];

        // Apply styles
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            2 => ['font' => ['italic' => true]],
            3 => ['font' => ['bold' => true]],
            'A5:D5' => $titleStyle,
            'A6:D6' => $headerStyle,
            'A10:D10' => $titleStyle,
            'A11:D11' => $headerStyle,
            'A15:D15' => $titleStyle,
            'A16:D16' => $headerStyle,
            'A20:D20' => $titleStyle,
            'A21:D21' => $headerStyle,
            'A25:D25' => $titleStyle,
            'A26:D26' => $headerStyle,
        ];
    }

    public function title(): string
    {
        return 'Analisis Data';
    }
}