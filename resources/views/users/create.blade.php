@extends('layouts.app')
@section('title', 'Tambah Pegawai')
@section('page-title', 'Tambah Pegawai')
@section('page-subtitle', 'Daftarkan akun pegawai baru')

@section('content')

<div class="max-w-2xl">
    <a href="{{ route('owner.users.index') }}" class="btn-secondary btn-sm mb-5 inline-flex">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>

    <div class="card">
        <h2 class="font-bold text-base mb-5 pb-4 border-b border-dark-400">
            <i class="fas fa-user-plus text-emerald-400 mr-2"></i>Informasi Pegawai Baru
        </h2>

        <form method="POST" action="{{ route('owner.users.store') }}" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label" for="name">Nama Lengkap <span class="text-red-400">*</span></label>
                    <input id="name" name="name" type="text"
                        class="form-input @error('name') border-red-500 @enderror"
                        value="{{ old('name') }}" placeholder="Nama lengkap">
                    @error('name') <p class="form-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label" for="telepon">No. Telepon</label>
                    <input id="telepon" name="telepon" type="text"
                        class="form-input" value="{{ old('telepon') }}" placeholder="0812xxxxxxxx">
                </div>
            </div>

            <div>
                <label class="form-label" for="email">Email <span class="text-red-400">*</span></label>
                <input id="email" name="email" type="email"
                    class="form-input @error('email') border-red-500 @enderror"
                    value="{{ old('email') }}" placeholder="email@jaymart.id">
                @error('email') <p class="form-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label" for="password">Password <span class="text-red-400">*</span></label>
                    <input id="password" name="password" type="password"
                        class="form-input @error('password') border-red-500 @enderror"
                        placeholder="Minimal 8 karakter">
                    @error('password') <p class="form-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label" for="password_confirmation">Konfirmasi Password <span class="text-red-400">*</span></label>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                        class="form-input" placeholder="Ulangi password">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label" for="role">Role / Jabatan <span class="text-red-400">*</span></label>
                    <select id="role" name="role" class="form-input @error('role') border-red-500 @enderror">
                        <option value="">-- Pilih Role --</option>
                        <option value="manajer"    {{ old('role') === 'manajer'    ? 'selected' : '' }}>Manajer Toko</option>
                        <option value="supervisor" {{ old('role') === 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                        <option value="kasir"      {{ old('role') === 'kasir'      ? 'selected' : '' }}>Kasir</option>
                        <option value="gudang"     {{ old('role') === 'gudang'     ? 'selected' : '' }}>Pegawai Gudang</option>
                    </select>
                    @error('role') <p class="form-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label" for="cabang_id">Cabang <span class="text-red-400">*</span></label>
                    <select id="cabang_id" name="cabang_id" class="form-input @error('cabang_id') border-red-500 @enderror">
                        <option value="">-- Pilih Cabang --</option>
                        @foreach ($cabang as $c)
                            <option value="{{ $c->id }}" {{ old('cabang_id') == $c->id ? 'selected' : '' }}>{{ $c->nama_cabang }}</option>
                        @endforeach
                    </select>
                    @error('cabang_id') <p class="form-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center gap-2.5 pt-1">
                <input id="is_active" name="is_active" type="checkbox" value="1"
                    class="w-4 h-4 accent-emerald-500 rounded"
                    {{ old('is_active', true) ? 'checked' : '' }}>
                <label for="is_active" class="text-sm text-slate-300 cursor-pointer">Akun Aktif</label>
            </div>

            <div class="flex gap-3 pt-2 border-t border-dark-400">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-floppy-disk"></i> Simpan Pegawai
                </button>
                <a href="{{ route('owner.users.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
