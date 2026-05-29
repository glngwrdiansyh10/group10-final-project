<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;

class CabangController extends Controller
{
    public function index()
    {
        $cabang = Cabang::withCount('users')->latest()->get();
        return view('cabang.index', compact('cabang'));
    }

    public function create()
    {
        return view('cabang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_cabang' => ['required', 'string', 'max:100'],
            'kota'        => ['required', 'string', 'max:100'],
            'alamat'      => ['required', 'string'],
            'telepon'     => ['nullable', 'string', 'max:20'],
            'is_active'   => ['boolean'],
        ]);

        Cabang::create($validated);

        return redirect()->route('cabang.index')
            ->with('success', 'Cabang berhasil ditambahkan.');
    }

    public function edit(Cabang $cabang)
    {
        return view('cabang.edit', compact('cabang'));
    }

    public function update(Request $request, Cabang $cabang)
    {
        $validated = $request->validate([
            'nama_cabang' => ['required', 'string', 'max:100'],
            'kota'        => ['required', 'string', 'max:100'],
            'alamat'      => ['required', 'string'],
            'telepon'     => ['nullable', 'string', 'max:20'],
            'is_active'   => ['boolean'],
        ]);

        $cabang->update($validated);

        return redirect()->route('cabang.index')
            ->with('success', 'Data cabang berhasil diperbarui.');
    }

    public function destroy(Cabang $cabang)
    {
        if ($cabang->users()->exists()) {
            return back()->with('error', 'Cabang tidak dapat dihapus karena masih memiliki pegawai.');
        }

        $cabang->delete();

        return redirect()->route('cabang.index')
            ->with('success', 'Cabang berhasil dihapus.');
    }
}
