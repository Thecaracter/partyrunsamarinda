<?php

namespace App\Exports;

use App\Models\Peserta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Support\Facades\DB;

class PesertaDataSheet implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting
{
    public function collection()
    {
        return Peserta::select(
            'kode_bib',
            'nama_lengkap',
            'nama_bib',
            'email',
            'no_wa',
            'provinsi',
            'kecamatan',
            'kelurahan',
            'kota',
            'alamat',
            'usia',
            'kategori',
            DB::raw('(SELECT name FROM sizes WHERE id = peserta.size_id) as ukuran'),
            'golongan_darah',
            DB::raw('CASE WHEN ada_alergi = 1 THEN "Ya" ELSE "Tidak" END as ada_alergi'),
            'riwayat_penyakit',
            'emergency_nama',
            'emergency_nomor',
            'status_pembayaran',
            'payment_date',
            'amount',
            DB::raw('CASE WHEN is_checked_in = 1 THEN "Sudah" ELSE "Belum" END as is_checked_in'),
            'check_in_time'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Kode BIB',
            'Nama Lengkap',
            'Nama BIB',
            'Email',
            'No. WhatsApp',
            'Provinsi',
            'Kecamatan',
            'Kelurahan',
            'Kota',
            'Alamat',
            'Usia',
            'Kategori',
            'Ukuran Baju',
            'Golongan Darah',
            'Ada Alergi',
            'Riwayat Penyakit',
            'Nama Kontak Darurat',
            'Nomor Kontak Darurat',
            'Status Pembayaran',
            'Tanggal Pembayaran',
            'Jumlah Pembayaran',
            'Status Check-in',
            'Waktu Check-in'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(40);

        return [
            1 => ['font' => ['bold' => true]],
            'A1:W1' => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => 'E9D5FF']
                ]
            ],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'K' => NumberFormat::FORMAT_NUMBER,
            'T' => NumberFormat::FORMAT_DATE_DATETIME,
            'U' => '"Rp"#,##0.00_-',
            'W' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }
}