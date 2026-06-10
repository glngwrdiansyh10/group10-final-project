<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class SupervisorDashboardController extends Controller
{
    public function index()
    {
        $cabangId = auth()->user()->cabang_id;
        $cabang   = auth()->user()->cabang;

        $transaksiHariIni = Transaksi::with('kasir')
            ->where('cabang_id', $cabangId)
            ->whereDate('created_at', today())
            ->where('status', 'selesai')
            ->latest()->get();

        $omzetHariIni = $transaksiHariIni->sum('total');

        $stokKritis = Stok::with('produk')
            ->where('cabang_id', $cabangId)
            ->whereColumn('jumlah', '<=', DB::raw('(SELECT stok_minimum FROM produk WHERE produk.id = stok.produk_id)'))
            ->get();

        $stokHabis = Stok::with('produk')
            ->where('cabang_id', $cabangId)
            ->where('jumlah', 0)->get();

        return view('dashboard.supervisor', compact(
            'cabang', 'transaksiHariIni', 'omzetHariIni',
            'stokKritis', 'stokHabis'
        ));
    }
}