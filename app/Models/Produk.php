<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'kategori',
        'satuan',
        'harga_beli',
        'harga_jual',
        'stok_minimum',
        'is_active',
    ];

    protected $casts = [
        'harga_beli'    => 'decimal:2',
        'harga_jual'    => 'decimal:2',
        'is_active'     => 'boolean',
    ];

    // Relationships
    public function stok()
    {
        return $this->hasMany(Stok::class);
    }

    public function mutasiStok()
    {
        return $this->hasMany(MutasiStok::class);
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    // Get stok for specific branch
    public function stokCabang($cabangId)
    {
        return $this->stok()->where('cabang_id', $cabangId)->first()?->jumlah ?? 0;
    }
}
