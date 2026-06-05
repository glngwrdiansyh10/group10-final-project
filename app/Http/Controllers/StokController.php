<?php

namespace App\Http\Controllers;

use App\Models\MutasiStok;
use App\Models\Produk;
use App\Models\Stok;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
    // ── Lihat Stok Cabang ───────────────────────────────────────
    public function index(Request $request)
    {
        $cabangId = auth()->user()->cabang_id;

        $query = Stok::with('produk')
            ->where('cabang_id', $cabangId);

        if ($request->filled('search')) {
            $query->whereHas('produk', fn($q) =>
                $q->where('nama_produk', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_produk', 'like', '%' . $request->search . '%')
            );
        }

        if ($request->filled('kategori')) {
            $query->whereHas('produk', fn($q) =>
                $q->where('kategori', $request->kategori)
            );
        }

        if ($request->filter === 'kritis') {
            $query->whereColumn('jumlah', '<=',
                DB::raw('(SELECT stok_minimum FROM produk WHERE produk.id = stok.produk_id)')
            )->where('jumlah', '>', 0);
        }

        if ($request->filter === 'habis') {
            $query->where('jumlah', 0);
        }

        $stok      = $query->paginate(15)->withQueryString();
        $kategori  = Produk::distinct()->pluck('kategori');
        $stokKritis = Stok::where('cabang_id', $cabangId)
            ->whereColumn('jumlah', '<=', DB::raw('(SELECT stok_minimum FROM produk WHERE produk.id = stok.produk_id)'))
            ->where('jumlah', '>', 0)->count();
        $stokHabis  = Stok::where('cabang_id', $cabangId)->where('jumlah', 0)->count();

        return view('stok.index', compact('stok', 'kategori', 'stokKritis', 'stokHabis'));
    }

    // ── Laporan Stok ────────────────────────────────────────────
    public function laporan(Request $request)
    {
        $cabangId = auth()->user()->cabang_id;
        $cabang   = auth()->user()->cabang;

        $stok = Stok::with('produk')
            ->where('cabang_id', $cabangId)
            ->get()
            ->sortBy('produk.kategori');

        $totalNilaiStok = $stok->sum(fn($s) => $s->jumlah * $s->produk->harga_beli);

        return view('stok.laporan', compact('stok', 'cabang', 'totalNilaiStok'));
    }

    // ── Cetak Laporan Stok PDF ──────────────────────────────────
    public function cetakLaporan()
    {
        $cabangId = auth()->user()->cabang_id;
        $cabang   = auth()->user()->cabang;

        $stok = Stok::with('produk')
            ->where('cabang_id', $cabangId)
            ->get()
            ->sortBy('produk.kategori');

        $totalNilaiStok = $stok->sum(fn($s) => $s->jumlah * $s->produk->harga_beli);

        $pdf = Pdf::loadView('stok.laporan-pdf', compact('stok', 'cabang', 'totalNilaiStok'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download("laporan-stok-{$cabang->nama_cabang}-" . now()->format('Y-m-d') . ".pdf");
    }
}
