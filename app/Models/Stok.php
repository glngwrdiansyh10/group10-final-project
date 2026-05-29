<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $table = 'stok';

    protected $fillable = [
        'produk_id',
        'cabang_id',
        'jumlah',
    ];

    // Relationships
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    // Check if stock is low
    public function isStokKritis(): bool
    {
        return $this->jumlah <= $this->produk->stok_minimum;
    }
}
