<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Stok;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        // Stats hari ini (semua cabang)
        $totalTransaksiHariIni = Transaksi::whereDate('created_at', today())
            ->where('status', 'selesai')
            ->count();

        $omzetHariIni = Transaksi::whereDate('created_at', today())
            ->where('status', 'selesai')
            ->sum('total');

        $omzetBulanIni = Transaksi::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', 'selesai')
            ->sum('total');

        $totalPegawai = User::where('role', '!=', 'owner')->where('is_active', true)->count();

        // Stok kritis (jumlah stok <= stok_minimum produk)
        $stokKritis = Stok::with(['produk', 'cabang'])
            ->whereColumn('jumlah', '<=', DB::raw('(SELECT stok_minimum FROM produk WHERE produk.id = stok.produk_id)'))
            ->where('jumlah', '>', 0)
            ->count();

        $stokHabis = Stok::where('jumlah', 0)->count();

        // Data per cabang
        $cabangList = Cabang::where('is_active', true)->get()->map(function ($cabang) {
            $cabang->transaksi_hari_ini = Transaksi::where('cabang_id', $cabang->id)
                ->whereDate('created_at', today())
                ->where('status', 'selesai')
                ->count();
            $cabang->omzet_hari_ini = Transaksi::where('cabang_id', $cabang->id)
                ->whereDate('created_at', today())
                ->where('status', 'selesai')
                ->sum('total');
            $cabang->omzet_bulan_ini = Transaksi::where('cabang_id', $cabang->id)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->where('status', 'selesai')
                ->sum('total');
            return $cabang;
        });

        // Chart: omzet 7 hari terakhir per cabang
        $chartLabels = [];
        $chartData   = [];
        for ($i = 6; $i >= 0; $i--) {
            $date          = now()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $chartData[]   = (float) Transaksi::whereDate('created_at', $date)
                ->where('status', 'selesai')
                ->sum('total');
        }

        // Transaksi terbaru
        $transaksiTerbaru = Transaksi::with(['cabang', 'kasir'])
            ->latest()
            ->take(8)
            ->get();

        return view('dashboard.owner', compact(
            'totalTransaksiHariIni',
            'omzetHariIni',
            'omzetBulanIni',
            'totalPegawai',
            'stokKritis',
            'stokHabis',
            'cabangList',
            'chartLabels',
            'chartData',
            'transaksiTerbaru'
        ));
    }
}
