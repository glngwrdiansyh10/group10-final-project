<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'role',
        'cabang_id',
        'email',
        'telepon',
        'is_active',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    // Relationships
    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'kasir_id');
    }

    public function mutasiStok()
    {
        return $this->hasMany(MutasiStok::class);
    }

    // Helpers
    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    public function isManajer(): bool
    {
        return $this->role === 'manajer';
    }

    public function isSupervisor(): bool
    {
        return $this->role === 'supervisor';
    }

    public function isKasir(): bool
    {
        return $this->role === 'kasir';
    }

    public function isGudang(): bool
    {
        return $this->role === 'gudang';
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'owner'      => 'Owner',
            'manajer'    => 'Manajer Toko',
            'supervisor' => 'Supervisor',
            'kasir'      => 'Kasir',
            'gudang'     => 'Pegawai Gudang',
            default      => ucfirst($this->role),
        };
    }
}
