<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;

    protected $table = 'cabang';

    protected $fillable = [
        'nama_cabang',
        'kota',
        'alamat',
        'telepon',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function stok()
    {
        return $this->hasMany(Stok::class);
    }

    public function mutasiStok()
    {
        return $this->hasMany(MutasiStok::class);
    }

    // Helpers
    public function getTotalTransaksiHariIniAttribute()
    {
        return $this->transaksi()
            ->whereDate('created_at', today())
            ->where('status', 'selesai')
            ->count();
    }

    public function getOmzetHariIniAttribute()
    {
        return $this->transaksi()
            ->whereDate('created_at', today())
            ->where('status', 'selesai')
            ->sum('total');
    }
}
