<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Stok;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    // ── Kasir: Halaman POS (Point of Sale) ─────────────────────
    public function kasirIndex()
    {
        $produk = Produk::where('is_active', true)
            ->with(['stok' => fn($q) => $q->where('cabang_id', auth()->user()->cabang_id)])
            ->get()
            ->filter(fn($p) => ($p->stok->first()?->jumlah ?? 0) > 0);

        return view('kasir.pos', compact('produk'));
    }

    // ── Kasir: Simpan Transaksi ─────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'items'   => ['required', 'array', 'min:1'],
            'items.*.produk_id' => ['required', 'exists:produk,id'],
            'items.*.jumlah'    => ['required', 'integer', 'min:1'],
            'bayar'   => ['required', 'numeric', 'min:0'],
        ]);

        DB::beginTransaction();
        try {
            $subtotal = 0;
            $details  = [];

            foreach ($request->items as $item) {
                $produk = Produk::findOrFail($item['produk_id']);
                $stok   = Stok::where('produk_id', $produk->id)
                               ->where('cabang_id', auth()->user()->cabang_id)
                               ->first();

                if (!$stok || $stok->jumlah < $item['jumlah']) {
                    return back()->with('error', "Stok {$produk->nama_produk} tidak mencukupi.");
                }

                $itemSubtotal = $produk->harga_jual * $item['jumlah'];
                $subtotal    += $itemSubtotal;
                $details[]    = [
                    'produk'  => $produk,
                    'jumlah'  => $item['jumlah'],
                    'subtotal'=> $itemSubtotal,
                ];
            }

            $total     = $subtotal;
            $kembalian = $request->bayar - $total;

            if ($kembalian < 0) {
                return back()->with('error', 'Jumlah bayar kurang dari total belanja.');
            }

            // Buat transaksi
            $transaksi = Transaksi::create([
                'nomor_transaksi' => Transaksi::generateNomor(),
                'cabang_id'       => auth()->user()->cabang_id,
                'kasir_id'        => auth()->id(),
                'subtotal'        => $subtotal,
                'diskon'          => 0,
                'total'           => $total,
                'bayar'           => $request->bayar,
                'kembalian'       => $kembalian,
                'status'          => 'selesai',
            ]);

            // Simpan detail & kurangi stok
            foreach ($details as $d) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id'    => $d['produk']->id,
                    'jumlah'       => $d['jumlah'],
                    'harga_satuan' => $d['produk']->harga_jual,
                    'subtotal'     => $d['subtotal'],
                ]);

                Stok::where('produk_id', $d['produk']->id)
                    ->where('cabang_id', auth()->user()->cabang_id)
                    ->decrement('jumlah', $d['jumlah']);
            }

            DB::commit();
            return redirect()->route('kasir.struk', $transaksi)
                ->with('success', 'Transaksi berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ── Kasir: Cetak Struk ──────────────────────────────────────
    public function struk(Transaksi $transaksi)
    {
        if ($transaksi->cabang_id !== auth()->user()->cabang_id) {
            abort(403);
        }
        $transaksi->load('detailTransaksi.produk', 'cabang', 'kasir');
        return view('kasir.struk', compact('transaksi'));
    }

    // ── Kasir: Riwayat Transaksi ────────────────────────────────
    public function riwayat(Request $request)
    {
        $query = Transaksi::with('kasir')
            ->where('cabang_id', auth()->user()->cabang_id);

        if (auth()->user()->isKasir()) {
            $query->where('kasir_id', auth()->id());
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $transaksi = $query->latest()->paginate(15)->withQueryString();
        return view('kasir.riwayat', compact('transaksi'));
    }

    // ── Manajer: Laporan Transaksi ──────────────────────────────
    public function laporan(Request $request)
    {
        $cabangId   = auth()->user()->cabang_id;
        $dari       = $request->dari   ?? now()->startOfMonth()->format('Y-m-d');
        $sampai     = $request->sampai ?? now()->format('Y-m-d');

        $transaksi  = Transaksi::with(['kasir', 'detailTransaksi'])
            ->where('cabang_id', $cabangId)
            ->where('status', 'selesai')
            ->whereBetween('created_at', [$dari . ' 00:00:00', $sampai . ' 23:59:59'])
            ->latest()
            ->get();

        $totalOmzet = $transaksi->sum('total');
        $totalTrx   = $transaksi->count();

        return view('transaksi.laporan', compact('transaksi', 'dari', 'sampai', 'totalOmzet', 'totalTrx'));
    }

    // ── Manajer: Cetak Laporan PDF ──────────────────────────────
    public function cetakLaporan(Request $request)
    {
        $cabangId   = auth()->user()->cabang_id;
        $dari       = $request->dari   ?? now()->startOfMonth()->format('Y-m-d');
        $sampai     = $request->sampai ?? now()->format('Y-m-d');

        $transaksi  = Transaksi::with(['kasir', 'detailTransaksi'])
            ->where('cabang_id', $cabangId)
            ->where('status', 'selesai')
            ->whereBetween('created_at', [$dari . ' 00:00:00', $sampai . ' 23:59:59'])
            ->latest()
            ->get();

        $totalOmzet = $transaksi->sum('total');
        $cabang     = auth()->user()->cabang;

        $pdf = Pdf::loadView('transaksi.laporan-pdf', compact('transaksi', 'dari', 'sampai', 'totalOmzet', 'cabang'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download("laporan-transaksi-{$dari}-sampai-{$sampai}.pdf");
    }

    // ── Detail Transaksi ────────────────────────────────────────
    public function show(Transaksi $transaksi)
    {
        if ($transaksi->cabang_id !== auth()->user()->cabang_id) {
            abort(403);
        }
        $transaksi->load('detailTransaksi.produk', 'cabang', 'kasir');
        return view('transaksi.show', compact('transaksi'));
    }
}