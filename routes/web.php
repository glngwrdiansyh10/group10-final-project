<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\ManajerDashboardController;
use App\Http\Controllers\MutasiStokController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\SupervisorDashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ─── Auth Routes ─────────────────────────────────────────────────────────────
Route::get('/', function () {
    if (auth()->check()) {
        return match(auth()->user()->role) {
            'owner'      => redirect()->route('owner.dashboard'),
            'manajer'    => redirect()->route('manajer.dashboard'),
            'supervisor' => redirect()->route('supervisor.dashboard'),
            'kasir'      => redirect()->route('kasir.dashboard'),
            'gudang'     => redirect()->route('gudang.dashboard'),
            default      => redirect()->route('login'),
        };
    }
    return redirect()->route('login');
});
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ─── Owner ────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
    Route::resource('cabang', CabangController::class);
    Route::resource('users', UserController::class);
    Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
    Route::resource('produk', ProdukController::class);
});

// ─── Manajer ──────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:manajer'])->prefix('manajer')->name('manajer.')->group(function () {
    Route::get('/dashboard', [ManajerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/transaksi', [TransaksiController::class, 'laporan'])->name('transaksi.laporan');
    Route::get('/transaksi/cetak', [TransaksiController::class, 'cetakLaporan'])->name('transaksi.cetak');
    Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/stok', [StokController::class, 'laporan'])->name('stok.laporan');
    Route::get('/stok/cetak', [StokController::class, 'cetakLaporan'])->name('stok.cetak');
});

// ─── Supervisor ───────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:supervisor'])->prefix('supervisor')->name('supervisor.')->group(function () {
    Route::get('/dashboard', [SupervisorDashboardController::class, 'index'])->name('dashboard');
});

// ─── Kasir ────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/dashboard', [TransaksiController::class, 'kasirIndex'])->name('dashboard');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/struk/{transaksi}', [TransaksiController::class, 'struk'])->name('struk');
    Route::get('/riwayat', [TransaksiController::class, 'riwayat'])->name('riwayat');
    Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');
});

// ─── Gudang ───────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:gudang'])->prefix('gudang')->name('gudang.')->group(function () {
    Route::get('/dashboard', [StokController::class, 'index'])->name('dashboard');
    Route::get('/mutasi', [MutasiStokController::class, 'index'])->name('mutasi.index');
    Route::get('/mutasi/tambah', [MutasiStokController::class, 'create'])->name('mutasi.create');
    Route::post('/mutasi', [MutasiStokController::class, 'store'])->name('mutasi.store');
});