@extends('layouts.app')
@section('title', 'Edit Cabang')
@section('page-title', 'Edit Cabang')
@section('page-subtitle', 'Perbarui data ' . $cabang->nama_cabang)

@section('content')

<div class="max-w-xl">
    <a href="{{ route('owner.cabang.index') }}" class="btn-secondary btn-sm mb-5 inline-flex">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>

    <div class="card">
        <h2 class="font-bold text-base mb-5 pb-4 border-b border-dark-400">
            <i class="fas fa-pen-to-square text-emerald-400 mr-2"></i>Edit: {{ $cabang->nama_cabang }}
        </h2>

        <form method="POST" action="{{ route('owner.cabang.update', $cabang) }}" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="form-label" for="nama_cabang">Nama Cabang <span class="text-red-400">*</span></label>
                <input id="nama_cabang" name="nama_cabang" type="text"
                    class="form-input @error('nama_cabang') border-red-500 @enderror"
                    value="{{ old('nama_cabang', $cabang->nama_cabang) }}">
                @error('nama_cabang') <p class="form-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label" for="kota">Kota <span class="text-red-400">*</span></label>
                <input id="kota" name="kota" type="text"
                    class="form-input @error('kota') border-red-500 @enderror"
                    value="{{ old('kota', $cabang->kota) }}">
                @error('kota') <p class="form-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label" for="alamat">Alamat Lengkap <span class="text-red-400">*</span></label>
                <textarea id="alamat" name="alamat" rows="3"
                    class="form-input @error('alamat') border-red-500 @enderror resize-none">{{ old('alamat', $cabang->alamat) }}</textarea>
                @error('alamat') <p class="form-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label" for="telepon">No. Telepon</label>
                <input id="telepon" name="telepon" type="text"
                    class="form-input" value="{{ old('telepon', $cabang->telepon) }}">
            </div>

            <div class="flex items-center gap-2.5 pt-1">
                <input id="is_active" name="is_active" type="checkbox" value="1"
                    class="w-4 h-4 accent-emerald-500 rounded"
                    {{ old('is_active', $cabang->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="text-sm text-slate-300 cursor-pointer">Cabang Aktif</label>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-floppy-disk"></i> Simpan Perubahan
                </button>
                <a href="{{ route('owner.cabang.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
