<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peserta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'peserta';

    protected $fillable = [
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
        'size_id',
        'golongan_darah',
        'ada_alergi',
        'riwayat_penyakit',
        'emergency_nama',
        'emergency_nomor',
        'status_pembayaran',
        'midtrans_transaction_id',
        'midtrans_payment_type',
        'payment_date',
        'amount',
        'is_checked_in',
        'check_in_time',
        'checked_in_by'
    ];

    protected $casts = [
        'ada_alergi' => 'boolean',
        'is_checked_in' => 'boolean',
        'payment_date' => 'datetime',
        'check_in_time' => 'datetime',
        'amount' => 'decimal:2'
    ];

    public static function boot()
    {
        parent::boot();

        // Ketika pembayaran berhasil, generate kode BIB
        static::updating(function ($peserta) {
            if (
                $peserta->isDirty('status_pembayaran') &&
                $peserta->status_pembayaran === 'paid' &&
                empty($peserta->kode_bib)
            ) {
                $peserta->generateBibCode();
            }
        });
    }

    public function generateBibCode()
    {
        // Ambil kode BIB terakhir
        $lastBib = self::where('kode_bib', '!=', null)
            ->orderBy('kode_bib', 'desc')
            ->first();

        if ($lastBib) {
            // Jika sudah ada peserta sebelumnya, increment nomor terakhir
            $lastNumber = intval($lastBib->kode_bib);
            $nextNumber = $lastNumber + 1;
        } else {
            // Jika belum ada peserta, mulai dari 2001
            $nextNumber = 2001;
        }

        // Simpan nomor langsung tanpa padding karena sudah 4 digit
        $this->kode_bib = $nextNumber;
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}