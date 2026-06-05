<?php
$baseDir = "c:/xampp/htdocs/group10-final-project";
$outDir = "C:/Users/hjk/.gemini/antigravity/brain/c798b581-9f62-40e0-9108-e8f4554af967";

function getCode($file) {
    global $baseDir;
    $content = file_get_contents($baseDir . '/' . $file);
    return "```" . (str_ends_with($file, '.php') ? 'php' : 'html') . "\n" . $content . "\n```";
}

// NAZWA
$nazwa = "# 🧾 Panduan Mengerjakan Modul Transaksi (Nazwa)\n\n";
$nazwa .= "> Panduan ini berisi perintah langkah demi langkah beserta KODE yang harus kamu masukkan.\n\n";
$nazwa .= "## ⚠️ Persiapan Awal\n";
$nazwa .= "1. Clone repository:\n```bash\ngit clone https://github.com/glngwrdiansyh10/group10-final-project.git\ncd group10-final-project\n```\n";
$nazwa .= "2. Pindah ke branch kamu:\n```bash\ngit checkout feature/nazwa\n```\n\n";

$nazwa .= "## ✅ COMMIT 1 — Controller & Logika Transaksi\n";
$nazwa .= "1. Buat file `app/Http/Controllers/TransaksiController.php`\n";
$nazwa .= "2. Masukkan kode berikut:\n";
$nazwa .= "<details><summary>📄 Klik untuk Copy Kode TransaksiController.php</summary>\n\n" . getCode('app/Http/Controllers/TransaksiController.php') . "\n</details>\n\n";
$nazwa .= "3. Jalankan perintah di Terminal:\n```bash\ngit add app/Http/Controllers/TransaksiController.php\ngit commit -m \"feat(transaksi): implement TransaksiController logic for POS and reports\"\n```\n\n";

$nazwa .= "## ✅ COMMIT 2 — Antarmuka Kasir (POS, Struk, Riwayat)\n";
$nazwa .= "1. Buat file `resources/views/kasir/pos.blade.php`:\n";
$nazwa .= "<details><summary>📄 Klik untuk Copy Kode pos.blade.php</summary>\n\n" . getCode('resources/views/kasir/pos.blade.php') . "\n</details>\n\n";
$nazwa .= "2. Buat file `resources/views/kasir/struk.blade.php`:\n";
$nazwa .= "<details><summary>📄 Klik untuk Copy Kode struk.blade.php</summary>\n\n" . getCode('resources/views/kasir/struk.blade.php') . "\n</details>\n\n";
$nazwa .= "3. Buat file `resources/views/kasir/riwayat.blade.php`:\n";
$nazwa .= "<details><summary>📄 Klik untuk Copy Kode riwayat.blade.php</summary>\n\n" . getCode('resources/views/kasir/riwayat.blade.php') . "\n</details>\n\n";
$nazwa .= "4. Jalankan perintah di Terminal:\n```bash\ngit add resources/views/kasir/\ngit commit -m \"feat(transaksi): add POS interface, receipt, and history views for kasir\"\n```\n\n";

$nazwa .= "## ✅ COMMIT 3 — Laporan Transaksi untuk Manajer\n";
$nazwa .= "1. Buat file `resources/views/transaksi/laporan.blade.php`:\n";
$nazwa .= "<details><summary>📄 Klik untuk Copy Kode laporan.blade.php</summary>\n\n" . getCode('resources/views/transaksi/laporan.blade.php') . "\n</details>\n\n";
$nazwa .= "2. Buat file `resources/views/transaksi/laporan-pdf.blade.php`:\n";
$nazwa .= "<details><summary>📄 Klik untuk Copy Kode laporan-pdf.blade.php</summary>\n\n" . getCode('resources/views/transaksi/laporan-pdf.blade.php') . "\n</details>\n\n";
$nazwa .= "3. Buat file `resources/views/transaksi/show.blade.php`:\n";
$nazwa .= "<details><summary>📄 Klik untuk Copy Kode show.blade.php</summary>\n\n" . getCode('resources/views/transaksi/show.blade.php') . "\n</details>\n\n";
$nazwa .= "4. Jalankan perintah di Terminal:\n```bash\ngit add resources/views/transaksi/\ngit commit -m \"feat(transaksi): add transaction reports and PDF export layout for manajer\"\n```\n\n";

$nazwa .= "## ✅ COMMIT 4 — Routing Transaksi\n";
$nazwa .= "1. Buka file `routes/web.php` dan timpa seluruh isinya dengan kode ini:\n";
$nazwa .= "<details><summary>📄 Klik untuk Copy Kode routes/web.php</summary>\n\n" . getCode('routes/web.php') . "\n</details>\n\n";
$nazwa .= "2. Jalankan perintah di Terminal:\n```bash\ngit add routes/web.php\ngit commit -m \"feat(transaksi): register transaction and report routes\"\n```\n\n";

$nazwa .= "## 🚀 Tahap Akhir\n```bash\ngit push origin feature/nazwa\n```\n\nSelamat, tugasmu selesai! Kabari Gilang ya. 🎉\n";
file_put_contents($outDir . "/nazwa-walkthrough.md", $nazwa);

// ALI
$ali = "# 📦 Panduan Mengerjakan Modul Stok, Dashboard & Supervisor (Ali)\n\n";
$ali .= "> Panduan ini berisi perintah langkah demi langkah beserta KODE yang harus kamu masukkan.\n\n";
$ali .= "## ⚠️ Persiapan Awal\n";
$ali .= "1. Clone repository:\n```bash\ngit clone https://github.com/glngwrdiansyh10/group10-final-project.git\ncd group10-final-project\n```\n";
$ali .= "2. Pindah ke branch kamu:\n```bash\ngit checkout feature/ali\n```\n\n";

$ali .= "## ✅ COMMIT 1 — Controller & Logika Stok\n";
$ali .= "1. Buat file `app/Http/Controllers/StokController.php`:\n";
$ali .= "<details><summary>📄 Klik untuk Copy Kode StokController.php</summary>\n\n" . getCode('app/Http/Controllers/StokController.php') . "\n</details>\n\n";
$ali .= "2. Buat file `app/Http/Controllers/MutasiStokController.php`:\n";
$ali .= "<details><summary>📄 Klik untuk Copy Kode MutasiStokController.php</summary>\n\n" . getCode('app/Http/Controllers/MutasiStokController.php') . "\n</details>\n\n";
$ali .= "3. Buat file `app/Http/Controllers/ManajerDashboardController.php`:\n";
$ali .= "<details><summary>📄 Klik untuk Copy Kode ManajerDashboardController.php</summary>\n\n" . getCode('app/Http/Controllers/ManajerDashboardController.php') . "\n</details>\n\n";
$ali .= "4. Buat file `app/Http/Controllers/SupervisorDashboardController.php`:\n";
$ali .= "<details><summary>📄 Klik untuk Copy Kode SupervisorDashboardController.php</summary>\n\n" . getCode('app/Http/Controllers/SupervisorDashboardController.php') . "\n</details>\n\n";
$ali .= "5. Jalankan perintah di Terminal:\n```bash\ngit add app/Http/Controllers/StokController.php app/Http/Controllers/MutasiStokController.php app/Http/Controllers/ManajerDashboardController.php app/Http/Controllers/SupervisorDashboardController.php\ngit commit -m \"feat(stok): implement controllers for stock management and dashboards\"\n```\n\n";

$ali .= "## ✅ COMMIT 2 — Views Dashboard Manajer & Supervisor\n";
$ali .= "1. Timpa/buat file `resources/views/dashboard/manajer.blade.php`:\n";
$ali .= "<details><summary>📄 Klik untuk Copy Kode manajer.blade.php</summary>\n\n" . getCode('resources/views/dashboard/manajer.blade.php') . "\n</details>\n\n";
$ali .= "2. Timpa/buat file `resources/views/dashboard/supervisor.blade.php`:\n";
$ali .= "<details><summary>📄 Klik untuk Copy Kode supervisor.blade.php</summary>\n\n" . getCode('resources/views/dashboard/supervisor.blade.php') . "\n</details>\n\n";
$ali .= "3. Jalankan perintah di Terminal:\n```bash\ngit add resources/views/dashboard/manajer.blade.php resources/views/dashboard/supervisor.blade.php\ngit commit -m \"feat(stok): add branch dashboard views for manajer and supervisor\"\n```\n\n";

$ali .= "## ✅ COMMIT 3 — Views Modul Stok & Mutasi (Pegawai Gudang)\n";
$ali .= "1. Buat file `resources/views/stok/index.blade.php`:\n";
$ali .= "<details><summary>📄 Klik untuk Copy Kode stok/index.blade.php</summary>\n\n" . getCode('resources/views/stok/index.blade.php') . "\n</details>\n\n";
$ali .= "2. Buat file `resources/views/stok/laporan.blade.php`:\n";
$ali .= "<details><summary>📄 Klik untuk Copy Kode stok/laporan.blade.php</summary>\n\n" . getCode('resources/views/stok/laporan.blade.php') . "\n</details>\n\n";
$ali .= "3. Buat file `resources/views/stok/laporan-pdf.blade.php`:\n";
$ali .= "<details><summary>📄 Klik untuk Copy Kode stok/laporan-pdf.blade.php</summary>\n\n" . getCode('resources/views/stok/laporan-pdf.blade.php') . "\n</details>\n\n";
$ali .= "4. Buat file `resources/views/mutasi/index.blade.php`:\n";
$ali .= "<details><summary>📄 Klik untuk Copy Kode mutasi/index.blade.php</summary>\n\n" . getCode('resources/views/mutasi/index.blade.php') . "\n</details>\n\n";
$ali .= "5. Buat file `resources/views/mutasi/create.blade.php`:\n";
$ali .= "<details><summary>📄 Klik untuk Copy Kode mutasi/create.blade.php</summary>\n\n" . getCode('resources/views/mutasi/create.blade.php') . "\n</details>\n\n";
$ali .= "6. Jalankan perintah di Terminal:\n```bash\ngit add resources/views/stok/ resources/views/mutasi/\ngit commit -m \"feat(stok): add inventory management, mutations, and stock report views\"\n```\n\n";

$ali .= "## ✅ COMMIT 4 — Views Monitor Supervisor (Dashboard, Transaksi, Stok)\n";
$ali .= "> Ini adalah bagian **BARU** — modul Supervisor yang memungkinkan supervisor pantau transaksi & stok secara real-time.\n\n";
$ali .= "1. Timpa/buat file `resources/views/dashboard/supervisor.blade.php` (versi lengkap dengan chart):\n";
$ali .= "<details><summary>📄 Klik untuk Copy Kode dashboard/supervisor.blade.php</summary>\n\n" . getCode('resources/views/dashboard/supervisor.blade.php') . "\n</details>\n\n";
$ali .= "2. Buat folder `resources/views/supervisor/` lalu buat file `resources/views/supervisor/transaksi.blade.php`:\n";
$ali .= "<details><summary>📄 Klik untuk Copy Kode supervisor/transaksi.blade.php</summary>\n\n" . getCode('resources/views/supervisor/transaksi.blade.php') . "\n</details>\n\n";
$ali .= "3. Buat file `resources/views/supervisor/transaksi-show.blade.php`:\n";
$ali .= "<details><summary>📄 Klik untuk Copy Kode supervisor/transaksi-show.blade.php</summary>\n\n" . getCode('resources/views/supervisor/transaksi-show.blade.php') . "\n</details>\n\n";
$ali .= "4. Buat file `resources/views/supervisor/stok.blade.php`:\n";
$ali .= "<details><summary>📄 Klik untuk Copy Kode supervisor/stok.blade.php</summary>\n\n" . getCode('resources/views/supervisor/stok.blade.php') . "\n</details>\n\n";
$ali .= "5. Jalankan perintah di Terminal:\n```bash\ngit add resources/views/supervisor/ resources/views/dashboard/supervisor.blade.php\ngit commit -m \"feat(supervisor): add real-time monitoring dashboard for supervisor role\"\n```\n\n";

$ali .= "## ✅ COMMIT 5 — Routing & Sidebar (Update Final)\n";
$ali .= "1. Buka file `routes/web.php` dan timpa seluruh isinya dengan kode ini (sudah include route supervisor):\n";
$ali .= "<details><summary>📄 Klik untuk Copy Kode routes/web.php</summary>\n\n" . getCode('routes/web.php') . "\n</details>\n\n";
$ali .= "2. Buka file `resources/views/layouts/sidebar-nav.blade.php` dan timpa seluruh isinya:\n";
$ali .= "<details><summary>📄 Klik untuk Copy Kode sidebar-nav.blade.php</summary>\n\n" . getCode('resources/views/layouts/sidebar-nav.blade.php') . "\n</details>\n\n";
$ali .= "3. Jalankan perintah di Terminal:\n```bash\ngit add routes/web.php resources/views/layouts/sidebar-nav.blade.php\ngit commit -m \"feat(supervisor): register supervisor monitor routes and update sidebar navigation\"\n```\n\n";

$ali .= "## 🚀 Tahap Akhir\n```bash\ngit push origin feature/ali\n```\n\nSelamat, tugasmu selesai! Kabari Gilang ya. 🎉\n";
file_put_contents($outDir . "/ali-walkthrough.md", $ali);
echo "Berhasil!";


