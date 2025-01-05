<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'stock'
    ];

    public function peserta()
    {
        return $this->hasMany(Peserta::class);
    }

    public function decrementStockForPeserta()
    {
        if ($this->stock > 0) {
            $this->decrement('stock');
            return true;
        }
        throw new \Exception('Stok jersey untuk ukuran yang dipilih sudah habis');
    }
}