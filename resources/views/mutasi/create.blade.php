php
@extends('layouts.app')
@section('title', 'Input Mutasi Stok')
@section('page-title', 'Input Mutasi Stok')
@section('page-subtitle', 'Cabang: ' . auth()->user()->cabang->nama_cabang)

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('gudang.mutasi.index') }}" class="btn-secondary btn-sm mb-5 inline-flex">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>

    <div class="card">
        <h2 class="font-bold text-base mb-5 pb-4 border-b border-dark-400">
            <i class="fas fa-boxes-stacked text-emerald-400 mr-2"></i>Form Mutasi Stok
        </h2>

        <form method="POST" action="{{ route('gudang.mutasi.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="form-label" for="produk_id">Pilih Produk <span class="text-red-400">*</span></label>
                <select id="produk_id" name="produk_id" class="form-input @error('produk_id') border-red-500 @enderror">
                    <option value="">-- Pilih Produk --</option>
                    @foreach ($produk as $p)
                        @php $stokJumlah = $p->stok->first()?->jumlah ?? 0; @endphp
                        <option value="{{ $p->id }}" {{ old('produk_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->kode_produk }} — {{ $p->nama_produk }} (Tersedia: {{ $stokJumlah }} {{ $p->satuan }})
                        </option>
                    @endforeach
                </select>
                @error('produk_id') <p class="form-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label" for="tipe">Tipe Mutasi <span class="text-red-400">*</span></label>
                    <select id="tipe" name="tipe" class="form-input @error('tipe') border-red-500 @enderror">
                        <option value="masuk"  {{ old('tipe') === 'masuk'  ? 'selected' : '' }}>Stok Masuk (+)</option>
                        <option value="keluar" {{ old('tipe') === 'keluar' ? 'selected' : '' }}>Stok Keluar (-)</option>
                    </select>
                    @error('tipe') <p class="form-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label" for="jumlah">Jumlah <span class="text-red-400">*</span></label>
                    <input id="jumlah" name="jumlah" type="number" min="1"
                        class="form-input @error('jumlah') border-red-500 @enderror"
                        value="{{ old('jumlah', 1) }}" placeholder="1">
                    @error('jumlah') <p class="form-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="form-label" for="keterangan">Keterangan / Alasan</label>
                <textarea id="keterangan" name="keterangan" rows="2"
                    class="form-input resize-none"
                    placeholder="Contoh: Barang retur, stok opname, atau rusak...">{{ old('keterangan') }}</textarea>
            </div>

            <div class="flex gap-3 pt-2 border-t border-dark-400">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-floppy-disk"></i> Simpan Mutasi
                </button>
                <a href="{{ route('gudang.mutasi.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection