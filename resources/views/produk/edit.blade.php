@extends('layouts.app')
@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')
@section('page-subtitle', $produk->nama_produk)

@section('content')

<div class="max-w-2xl">
    <a href="{{ route('owner.produk.index') }}" class="btn-secondary btn-sm mb-5 inline-flex">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>

    <div class="card">
        <h2 class="font-bold text-base mb-5 pb-4 border-b border-dark-400">
            <i class="fas fa-pen-to-square text-emerald-400 mr-2"></i>Edit: {{ $produk->nama_produk }}
        </h2>

        <form method="POST" action="{{ route('owner.produk.update', $produk) }}" class="space-y-4">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label" for="kode_produk">Kode Produk <span class="text-red-400">*</span></label>
                    <input id="kode_produk" name="kode_produk" type="text"
                        class="form-input @error('kode_produk') border-red-500 @enderror"
                        value="{{ old('kode_produk', $produk->kode_produk) }}">
                    @error('kode_produk') <p class="form-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label" for="nama_produk">Nama Produk <span class="text-red-400">*</span></label>
                    <input id="nama_produk" name="nama_produk" type="text"
                        class="form-input @error('nama_produk') border-red-500 @enderror"
                        value="{{ old('nama_produk', $produk->nama_produk) }}">
                    @error('nama_produk') <p class="form-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label" for="kategori">Kategori <span class="text-red-400">*</span></label>
                    <input id="kategori" name="kategori" type="text"
                        class="form-input" value="{{ old('kategori', $produk->kategori) }}"
                        list="kategori-list">
                    <datalist id="kategori-list">
                        @foreach($kategori as $k)<option value="{{ $k }}">@endforeach
                    </datalist>
                </div>
                <div>
                    <label class="form-label" for="satuan">Satuan <span class="text-red-400">*</span></label>
                    <select id="satuan" name="satuan" class="form-input">
                        @foreach(['pcs','botol','kaleng','kardus','kg','gram','liter','dus'] as $s)
                            <option value="{{ $s }}" {{ old('satuan', $produk->satuan) === $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label" for="harga_beli">Harga Beli (Rp) <span class="text-red-400">*</span></label>
                    <input id="harga_beli" name="harga_beli" type="number" min="0"
                        class="form-input" value="{{ old('harga_beli', $produk->harga_beli) }}">
                </div>
                <div>
                    <label class="form-label" for="harga_jual">Harga Jual (Rp) <span class="text-red-400">*</span></label>
                    <input id="harga_jual" name="harga_jual" type="number" min="0"
                        class="form-input" value="{{ old('harga_jual', $produk->harga_jual) }}">
                </div>
            </div>

            <div class="max-w-xs">
                <label class="form-label" for="stok_minimum">Batas Stok Minimum</label>
                <input id="stok_minimum" name="stok_minimum" type="number" min="0"
                    class="form-input" value="{{ old('stok_minimum', $produk->stok_minimum) }}">
            </div>

            <div class="flex items-center gap-2.5">
                <input id="is_active" name="is_active" type="checkbox" value="1"
                    class="w-4 h-4 accent-emerald-500 rounded"
                    {{ old('is_active', $produk->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="text-sm text-slate-300 cursor-pointer">Produk Aktif</label>
            </div>

            <div class="flex gap-3 pt-2 border-t border-dark-400">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-floppy-disk"></i> Simpan Perubahan
                </button>
                <a href="{{ route('owner.produk.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
