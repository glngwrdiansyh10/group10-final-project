<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ─── Auth Routes ────────────────────────────────────────────────────────────
Route::get('/', fn () => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ─── Owner Routes ────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');

    // Cabang Management
    Route::resource('cabang', CabangController::class);

    // User Management
    Route::resource('users', UserController::class);
    Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');

    // Master Produk
    Route::resource('produk', ProdukController::class);
});

// ─── Manajer Routes ──────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:manajer'])->prefix('manajer')->name('manajer.')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard.manajer'))->name('dashboard');
    // Transaksi & Stok routes dikerjakan oleh Nazwa & Ali
});

// ─── Supervisor Routes ────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:supervisor'])->prefix('supervisor')->name('supervisor.')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard.supervisor'))->name('dashboard');
});

// ─── Kasir Routes ────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard.kasir'))->name('dashboard');
    // Transaksi routes dikerjakan oleh Nazwa
});

// ─── Gudang Routes ────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:gudang'])->prefix('gudang')->name('gudang.')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard.gudang'))->name('dashboard');
    // Mutasi stok routes dikerjakan oleh Ali
});
