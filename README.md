# 🏪 Jay-Mart — Sistem Informasi Mini Market

> Aplikasi berbasis web untuk memantau transaksi dan stok barang dari 5 cabang mini market milik Bapak Jayusman secara terpusat, kapan saja dan dari mana saja.

![Laravel](https://img.shields.io/badge/Laravel-13-red?logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.3-purple?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-blue?logo=mysql)
![Tailwind](https://img.shields.io/badge/TailwindCSS-4.0-38bdf8?logo=tailwindcss)

---

## 👥 Tim Pengembang — Kelompok 10

| Nama | NIM | Peran |
|------|-----|-------|
| Gilang Wardiansyah | - | Ketua — Setup, Auth, Dashboard Owner, Master Data |
| Nazwa Hafifah | - | Anggota — Modul Transaksi & Laporan |
| Ali Nurrohmat | - | Anggota — Modul Stok & Dashboard Manajer |

---

## ✨ Fitur Utama

- 🔐 **Multi-role login** — 5 level akses berbeda (Owner, Manajer, Supervisor, Kasir, Gudang)
- 📊 **Dashboard Owner** — pantau semua cabang, omzet harian & bulanan, grafik 7 hari
- 🏪 **Manajemen Cabang** — CRUD 5 cabang mini market
- 👤 **Manajemen Pegawai** — CRUD user dengan assign role & cabang
- 📦 **Master Produk** — CRUD produk dengan kategori & stok minimum
- 🛒 **Transaksi Penjualan** — input kasir, cetak struk *(dikerjakan Nazwa)*
- 📋 **Laporan Cetak** — laporan transaksi & stok per tanggal *(dikerjakan Nazwa & Ali)*
- 🏭 **Mutasi Stok** — kelola stok masuk/keluar *(dikerjakan Ali)*
- ⚠️ **Alert Stok Kritis** — notifikasi stok menipis

---

## 🛠️ Teknologi

| Layer | Teknologi |
|-------|-----------|
| Backend Framework | Laravel 13 |
| Bahasa | PHP 8.3 |
| Database | MySQL 8 (XAMPP) |
| Frontend | Blade Template + Tailwind CSS v4 |
| Build Tool | Vite |
| PDF/Cetak | barryvdh/laravel-dompdf |
| Chart | Chart.js 4 |
| Icon | Font Awesome 6 |

---

## ⚙️ Cara Instalasi

### Prasyarat
- XAMPP (Apache + MySQL aktif)
- PHP 8.3+
- Composer
- Node.js 18+

### Langkah-langkah

**1. Clone repository**
```bash
git clone https://github.com/[username]/group10-final-project.git
cd group10-final-project
```

**2. Install dependency PHP**
```bash
composer install
```

**3. Install dependency Node.js**
```bash
npm install
```

**4. Salin file environment**
```bash
cp .env.example .env
php artisan key:generate
```

**5. Konfigurasi database** — Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jaymart_db
DB_USERNAME=root
DB_PASSWORD=
```

**6. Buat database** di phpMyAdmin atau MySQL:
```sql
CREATE DATABASE jaymart_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**7. Jalankan migrasi & seeder**
```bash
php artisan migrate --seed
```

**8. Build asset Tailwind**
```bash
npm run build
```

**9. Jalankan server**
```bash
php artisan serve
```

Akses di: **http://localhost:8000**

---

## 🔑 Akun Demo

Semua akun menggunakan password: **`password`**

### Owner (Pak Jayusman)
| Email | Role |
|-------|------|
| owner@jaymart.id | Owner |

### Cabang 1 — Jay-Mart Cendana (Kotamara)
| Email | Role |
|-------|------|
| manajer1@jaymart.id | Manajer Toko |
| supervisor1@jaymart.id | Supervisor |
| kasir1@jaymart.id | Kasir |
| gudang1@jaymart.id | Pegawai Gudang |

### Cabang 2 — Jay-Mart Melati (Barualam)
| Email | Role |
|-------|------|
| manajer2@jaymart.id | Manajer Toko |
| kasir2@jaymart.id | Kasir |
| gudang2@jaymart.id | Pegawai Gudang |

> Pola email: `[role][nomor_cabang]@jaymart.id` (berlaku untuk cabang 3, 4, 5)

---

## 🌿 Struktur Branch GitHub

```
main          ← branch utama (production-ready)
  └── develop ← branch integrasi
        ├── feature/gilang   ← auth, dashboard, master data
        ├── feature/nazwa    ← modul transaksi
        └── feature/ali      ← modul stok & dashboard
```

---

## 🎬 Video Demo

📺 Link YouTube: *[akan diisi setelah upload]*

---

## 📁 Struktur Direktori Penting

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── OwnerDashboardController.php
│   │   ├── CabangController.php
│   │   ├── UserController.php
│   │   └── ProdukController.php
│   └── Middleware/
│       └── RoleMiddleware.php
└── Models/
    ├── User.php
    ├── Cabang.php
    ├── Produk.php
    ├── Stok.php
    ├── MutasiStok.php
    ├── Transaksi.php
    └── DetailTransaksi.php

database/
├── migrations/     ← 7 migration files
└── seeders/
    ├── CabangSeeder.php
    ├── UserSeeder.php
    └── ProdukSeeder.php

resources/views/
├── auth/login.blade.php
├── layouts/
│   ├── app.blade.php
│   └── sidebar-nav.blade.php
├── dashboard/
│   ├── owner.blade.php
│   └── [manajer|supervisor|kasir|gudang].blade.php
├── cabang/        ← index, create, edit
├── users/         ← index, create, edit
└── produk/        ← index, create, edit
```
