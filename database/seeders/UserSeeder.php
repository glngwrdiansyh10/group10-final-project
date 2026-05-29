<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── Owner (Pak Jayusman) — tidak terikat cabang ──────────
        User::create([
            'name'      => 'Bapak Jayusman',
            'email'     => 'owner@jaymart.id',
            'password'  => Hash::make('password'),
            'role'      => 'owner',
            'cabang_id' => null,
            'telepon'   => '0812-0000-0001',
            'is_active' => true,
        ]);

        // ── Pegawai per cabang (cabang_id 1-5) ──────────────────
        $pegawai = [
            // Cabang 1 - Cendana
            ['name' => 'Ahmad Manajer',     'email' => 'manajer1@jaymart.id',    'role' => 'manajer',    'cabang_id' => 1],
            ['name' => 'Budi Supervisor',   'email' => 'supervisor1@jaymart.id', 'role' => 'supervisor', 'cabang_id' => 1],
            ['name' => 'Citra Kasir',       'email' => 'kasir1@jaymart.id',      'role' => 'kasir',      'cabang_id' => 1],
            ['name' => 'Dian Gudang',       'email' => 'gudang1@jaymart.id',     'role' => 'gudang',     'cabang_id' => 1],

            // Cabang 2 - Melati
            ['name' => 'Eko Manajer',       'email' => 'manajer2@jaymart.id',    'role' => 'manajer',    'cabang_id' => 2],
            ['name' => 'Fitri Supervisor',  'email' => 'supervisor2@jaymart.id', 'role' => 'supervisor', 'cabang_id' => 2],
            ['name' => 'Gilang Kasir',      'email' => 'kasir2@jaymart.id',      'role' => 'kasir',      'cabang_id' => 2],
            ['name' => 'Hani Gudang',       'email' => 'gudang2@jaymart.id',     'role' => 'gudang',     'cabang_id' => 2],

            // Cabang 3 - Anggrek
            ['name' => 'Irfan Manajer',     'email' => 'manajer3@jaymart.id',    'role' => 'manajer',    'cabang_id' => 3],
            ['name' => 'Joko Supervisor',   'email' => 'supervisor3@jaymart.id', 'role' => 'supervisor', 'cabang_id' => 3],
            ['name' => 'Kiki Kasir',        'email' => 'kasir3@jaymart.id',      'role' => 'kasir',      'cabang_id' => 3],
            ['name' => 'Lina Gudang',       'email' => 'gudang3@jaymart.id',     'role' => 'gudang',     'cabang_id' => 3],

            // Cabang 4 - Kenanga
            ['name' => 'Miko Manajer',      'email' => 'manajer4@jaymart.id',    'role' => 'manajer',    'cabang_id' => 4],
            ['name' => 'Nana Supervisor',   'email' => 'supervisor4@jaymart.id', 'role' => 'supervisor', 'cabang_id' => 4],
            ['name' => 'Omar Kasir',        'email' => 'kasir4@jaymart.id',      'role' => 'kasir',      'cabang_id' => 4],
            ['name' => 'Putri Gudang',      'email' => 'gudang4@jaymart.id',     'role' => 'gudang',     'cabang_id' => 4],

            // Cabang 5 - Dahlia
            ['name' => 'Rizky Manajer',     'email' => 'manajer5@jaymart.id',    'role' => 'manajer',    'cabang_id' => 5],
            ['name' => 'Sari Supervisor',   'email' => 'supervisor5@jaymart.id', 'role' => 'supervisor', 'cabang_id' => 5],
            ['name' => 'Tono Kasir',        'email' => 'kasir5@jaymart.id',      'role' => 'kasir',      'cabang_id' => 5],
            ['name' => 'Umi Gudang',        'email' => 'gudang5@jaymart.id',     'role' => 'gudang',     'cabang_id' => 5],
        ];

        foreach ($pegawai as $data) {
            User::create(array_merge($data, [
                'password'  => Hash::make('password'),
                'telepon'   => null,
                'is_active' => true,
            ]));
        }
    }
}
