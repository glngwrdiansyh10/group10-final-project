<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::query();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_produk', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_produk', 'like', '%' . $request->search . '%');
            });
        }

        $produk    = $query->latest()->paginate(15)->withQueryString();
        $kategori  = Produk::distinct()->pluck('kategori');

        return view('produk.index', compact('produk', 'kategori'));
    }

    public function create()
    {
        $kategori = Produk::distinct()->pluck('kategori');
        return view('produk.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_produk'  => ['required', 'string', 'max:20', 'unique:produk'],
            'nama_produk'  => ['required', 'string', 'max:150'],
            'kategori'     => ['required', 'string', 'max:50'],
            'satuan'       => ['required', 'string', 'max:20'],
            'harga_beli'   => ['required', 'numeric', 'min:0'],
            'harga_jual'   => ['required', 'numeric', 'min:0'],
            'stok_minimum' => ['required', 'integer', 'min:0'],
            'is_active'    => ['boolean'],
        ]);

        Produk::create($validated);

        return redirect()->route('owner.produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $produk)
    {
        $kategori = Produk::distinct()->pluck('kategori');
        return view('produk.edit', compact('produk', 'kategori'));
    }

    public function update(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'kode_produk'  => ['required', 'string', 'max:20', Rule::unique('produk')->ignore($produk->id)],
            'nama_produk'  => ['required', 'string', 'max:150'],
            'kategori'     => ['required', 'string', 'max:50'],
            'satuan'       => ['required', 'string', 'max:20'],
            'harga_beli'   => ['required', 'numeric', 'min:0'],
            'harga_jual'   => ['required', 'numeric', 'min:0'],
            'stok_minimum' => ['required', 'integer', 'min:0'],
            'is_active'    => ['boolean'],
        ]);

        $produk->update($validated);

        return redirect()->route('owner.produk.index')
            ->with('success', 'Data produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        if ($produk->detailTransaksi()->exists()) {
            return back()->with('error', 'Produk tidak dapat dihapus karena sudah pernah ada dalam transaksi.');
        }

        $produk->delete();

        return redirect()->route('owner.produk.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
