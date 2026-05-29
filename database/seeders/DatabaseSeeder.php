<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CabangSeeder::class,  // 1. Cabang dulu (users butuh cabang_id)
            UserSeeder::class,    // 2. Users
            ProdukSeeder::class,  // 3. Produk + Stok awal
        ]);
    }
}
