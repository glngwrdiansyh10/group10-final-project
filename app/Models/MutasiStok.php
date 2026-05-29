<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutasiStok extends Model
{
    use HasFactory;

    protected $table = 'mutasi_stok';

    protected $fillable = [
        'produk_id',
        'cabang_id',
        'user_id',
        'tipe',
        'jumlah',
        'keterangan',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
