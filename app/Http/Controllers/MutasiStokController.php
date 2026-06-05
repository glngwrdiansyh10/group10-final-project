<?php

namespace App\Http\Controllers;

use App\Models\MutasiStok;
use App\Models\Produk;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MutasiStokController extends Controller
{
    // ── Riwayat Mutasi Stok ─────────────────────────────────────
    public function index(Request $request)
    {
        $cabangId = auth()->user()->cabang_id;

        $query = MutasiStok::with(['produk', 'user'])
            ->where('cabang_id', $cabangId);

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $mutasi = $query->latest()->paginate(15)->withQueryString();
        return view('mutasi.index', compact('mutasi'));
    }

    // ── Form Input Mutasi ───────────────────────────────────────
    public function create()
    {
        $cabangId = auth()->user()->cabang_id;
        $produk   = Produk::where('is_active', true)
            ->with(['stok' => fn($q) => $q->where('cabang_id', $cabangId)])
            ->get();

        return view('mutasi.create', compact('produk'));
    }

    // ── Simpan Mutasi Stok ──────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'produk_id'   => ['required', 'exists:produk,id'],
            'tipe'        => ['required', 'in:masuk,keluar'],
            'jumlah'      => ['required', 'integer', 'min:1'],
            'keterangan'  => ['nullable', 'string', 'max:200'],
        ]);

        $cabangId = auth()->user()->cabang_id;
        $stok     = Stok::firstOrCreate(
            ['produk_id' => $request->produk_id, 'cabang_id' => $cabangId],
            ['jumlah' => 0]
        );

        // Validasi stok keluar
        if ($request->tipe === 'keluar' && $stok->jumlah < $request->jumlah) {
            return back()->withErrors(['jumlah' => 'Stok tidak mencukupi. Stok tersedia: ' . $stok->jumlah])
                         ->withInput();
        }

        DB::beginTransaction();
        try {
            // Catat mutasi
            MutasiStok::create([
                'produk_id'  => $request->produk_id,
                'cabang_id'  => $cabangId,
                'user_id'    => auth()->id(),
                'tipe'       => $request->tipe,
                'jumlah'     => $request->jumlah,
                'keterangan' => $request->keterangan,
            ]);

            // Update stok
            if ($request->tipe === 'masuk') {
                $stok->increment('jumlah', $request->jumlah);
            } else {
                $stok->decrement('jumlah', $request->jumlah);
            }

            DB::commit();
            return redirect()->route('gudang.mutasi.index')
                ->with('success', 'Mutasi stok berhasil dicatat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
