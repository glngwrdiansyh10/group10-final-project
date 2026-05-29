<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\Stok;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $produk = [
            // Minuman
            ['kode' => 'MIN-001', 'nama' => 'Aqua Botol 600ml',        'kategori' => 'Minuman', 'satuan' => 'botol', 'beli' => 2500,  'jual' => 4000,  'min' => 20],
            ['kode' => 'MIN-002', 'nama' => 'Teh Botol Sosro 450ml',   'kategori' => 'Minuman', 'satuan' => 'botol', 'beli' => 4000,  'jual' => 6000,  'min' => 15],
            ['kode' => 'MIN-003', 'nama' => 'Coca-Cola Kaleng 330ml',  'kategori' => 'Minuman', 'satuan' => 'kaleng','beli' => 6000,  'jual' => 9000,  'min' => 12],
            ['kode' => 'MIN-004', 'nama' => 'Pocari Sweat 500ml',      'kategori' => 'Minuman', 'satuan' => 'botol', 'beli' => 7000,  'jual' => 10000, 'min' => 10],
            ['kode' => 'MIN-005', 'nama' => 'Kopi Kapal Api Sachet',   'kategori' => 'Minuman', 'satuan' => 'pcs',   'beli' => 1200,  'jual' => 2000,  'min' => 30],

            // Snack
            ['kode' => 'SNK-001', 'nama' => 'Chitato Sapi Panggang',   'kategori' => 'Snack',   'satuan' => 'pcs',   'beli' => 8000,  'jual' => 12000, 'min' => 10],
            ['kode' => 'SNK-002', 'nama' => 'Lays Original 68g',       'kategori' => 'Snack',   'satuan' => 'pcs',   'beli' => 10000, 'jual' => 14000, 'min' => 8],
            ['kode' => 'SNK-003', 'nama' => 'Oreo Original 119g',      'kategori' => 'Snack',   'satuan' => 'pcs',   'beli' => 9000,  'jual' => 13000, 'min' => 10],
            ['kode' => 'SNK-004', 'nama' => 'Good Time Cookies',       'kategori' => 'Snack',   'satuan' => 'pcs',   'beli' => 6000,  'jual' => 9000,  'min' => 12],
            ['kode' => 'SNK-005', 'nama' => 'Indomie Goreng',          'kategori' => 'Snack',   'satuan' => 'pcs',   'beli' => 2800,  'jual' => 4500,  'min' => 25],

            // Sembako
            ['kode' => 'SMB-001', 'nama' => 'Beras Premium 5kg',       'kategori' => 'Sembako', 'satuan' => 'kg',    'beli' => 65000, 'jual' => 80000, 'min' => 5],
            ['kode' => 'SMB-002', 'nama' => 'Gula Pasir 1kg',          'kategori' => 'Sembako', 'satuan' => 'kg',    'beli' => 13000, 'jual' => 17000, 'min' => 10],
            ['kode' => 'SMB-003', 'nama' => 'Minyak Goreng 2L',        'kategori' => 'Sembako', 'satuan' => 'botol', 'beli' => 28000, 'jual' => 35000, 'min' => 8],
            ['kode' => 'SMB-004', 'nama' => 'Tepung Terigu 1kg',       'kategori' => 'Sembako', 'satuan' => 'kg',    'beli' => 9000,  'jual' => 13000, 'min' => 10],
            ['kode' => 'SMB-005', 'nama' => 'Garam Dapur 500g',        'kategori' => 'Sembako', 'satuan' => 'pcs',   'beli' => 3000,  'jual' => 5000,  'min' => 15],

            // Perawatan Diri
            ['kode' => 'PRW-001', 'nama' => 'Sabun Lifebuoy 85g',      'kategori' => 'Perawatan','satuan' => 'pcs',  'beli' => 4000,  'jual' => 6500,  'min' => 10],
            ['kode' => 'PRW-002', 'nama' => 'Shampoo Pantene 170ml',   'kategori' => 'Perawatan','satuan' => 'botol','beli' => 18000, 'jual' => 25000, 'min' => 6],
            ['kode' => 'PRW-003', 'nama' => 'Pasta Gigi Pepsodent',    'kategori' => 'Perawatan','satuan' => 'pcs',  'beli' => 8000,  'jual' => 12000, 'min' => 8],

            // Rumah Tangga
            ['kode' => 'RTG-001', 'nama' => 'Deterjen Rinso 900g',     'kategori' => 'Rumah Tangga','satuan' => 'pcs', 'beli' => 18000, 'jual' => 25000, 'min' => 6],
            ['kode' => 'RTG-002', 'nama' => 'Sabun Sunlight 750ml',    'kategori' => 'Rumah Tangga','satuan' => 'botol','beli' => 9000, 'jual' => 14000, 'min' => 8],
        ];

        foreach ($produk as $data) {
            $p = Produk::create([
                'kode_produk'  => $data['kode'],
                'nama_produk'  => $data['nama'],
                'kategori'     => $data['kategori'],
                'satuan'       => $data['satuan'],
                'harga_beli'   => $data['beli'],
                'harga_jual'   => $data['jual'],
                'stok_minimum' => $data['min'],
                'is_active'    => true,
            ]);

            // Buat stok awal untuk setiap cabang (1-5)
            for ($cabangId = 1; $cabangId <= 5; $cabangId++) {
                Stok::create([
                    'produk_id' => $p->id,
                    'cabang_id' => $cabangId,
                    'jumlah'    => rand(10, 100),
                ]);
            }
        }
    }
}
