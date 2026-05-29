<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'nomor_transaksi',
        'cabang_id',
        'kasir_id',
        'subtotal',
        'diskon',
        'total',
        'bayar',
        'kembalian',
        'status',
        'catatan',
    ];

    protected $casts = [
        'subtotal'  => 'decimal:2',
        'diskon'    => 'decimal:2',
        'total'     => 'decimal:2',
        'bayar'     => 'decimal:2',
        'kembalian' => 'decimal:2',
    ];

    // Relationships
    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    // Generate unique transaction number
    public static function generateNomor(): string
    {
        $prefix = 'TRX-' . date('Ymd') . '-';
        $last   = self::where('nomor_transaksi', 'like', $prefix . '%')
                      ->orderByDesc('id')
                      ->first();

        $seq = $last ? (int) substr($last->nomor_transaksi, -4) + 1 : 1;

        return $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }
}
