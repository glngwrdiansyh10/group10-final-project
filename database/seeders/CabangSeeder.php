<?php

namespace Database\Seeders;

use App\Models\Cabang;
use Illuminate\Database\Seeder;

class CabangSeeder extends Seeder
{
    public function run(): void
    {
        $cabang = [
            ['nama_cabang' => 'Jay-Mart Cendana',  'kota' => 'Kotamara',   'alamat' => 'Jl. Cendana Raya No. 12, Kotamara',    'telepon' => '0811-1001-001'],
            ['nama_cabang' => 'Jay-Mart Melati',   'kota' => 'Barualam',   'alamat' => 'Jl. Melati Indah No. 45, Barualam',    'telepon' => '0811-1001-002'],
            ['nama_cabang' => 'Jay-Mart Anggrek',  'kota' => 'Suryakota',  'alamat' => 'Jl. Anggrek Permai No. 7, Suryakota',  'telepon' => '0811-1001-003'],
            ['nama_cabang' => 'Jay-Mart Kenanga',  'kota' => 'Pantaijaya', 'alamat' => 'Jl. Kenanga Baru No. 23, Pantaijaya',  'telepon' => '0811-1001-004'],
            ['nama_cabang' => 'Jay-Mart Dahlia',   'kota' => 'Gunungmas',  'alamat' => 'Jl. Dahlia Utama No. 88, Gunungmas',   'telepon' => '0811-1001-005'],
        ];

        foreach ($cabang as $data) {
            Cabang::create(array_merge($data, ['is_active' => true]));
        }
    }
}
