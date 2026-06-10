<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class ManajerDashboardController extends Controller
{
    public function index()
    {
        $cabangId = auth()->user()->cabang_id;
        $cabang   = auth()->user()->cabang;

        $transaksiHariIni = Transaksi::where('cabang_id', $cabangId)
            ->whereDate('created_at', today())
            ->where('status', 'selesai')->count();

        $omzetHariIni = Transaksi::where('cabang_id', $cabangId)
            ->whereDate('created_at', today())
            ->where('status', 'selesai')->sum('total');

        $omzetBulanIni = Transaksi::where('cabang_id', $cabangId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', 'selesai')->sum('total');

        $stokKritis = Stok::where('cabang_id', $cabangId)
            ->whereColumn('jumlah', '<=', DB::raw('(SELECT stok_minimum FROM produk WHERE produk.id = stok.produk_id)'))
            ->where('jumlah', '>', 0)->count();

        $stokHabis = Stok::where('cabang_id', $cabangId)->where('jumlah', 0)->count();

        $chartLabels = [];
        $chartData   = [];
        for ($i = 6; $i >= 0; $i--) {
            $date          = now()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $chartData[]   = (float) Transaksi::where('cabang_id', $cabangId)
                ->whereDate('created_at', $date)
                ->where('status', 'selesai')->sum('total');
        }

        $transaksiTerbaru = Transaksi::with('kasir')
            ->where('cabang_id', $cabangId)
            ->latest()->take(6)->get();

        return view('dashboard.manajer', compact(
            'cabang', 'transaksiHariIni', 'omzetHariIni',
            'omzetBulanIni', 'stokKritis', 'stokHabis',
            'chartLabels', 'chartData', 'transaksiTerbaru'
        ));
    }
}