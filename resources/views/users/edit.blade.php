@extends('layouts.app')
@section('title', 'Edit Pegawai')
@section('page-title', 'Edit Pegawai')
@section('page-subtitle', 'Perbarui data ' . $user->name)

@section('content')

<div class="max-w-2xl">
    <a href="{{ route('owner.users.index') }}" class="btn-secondary btn-sm mb-5 inline-flex">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>

    <div class="card">
        <div class="flex items-center gap-3 mb-5 pb-4 border-b border-dark-400">
            <div class="w-10 h-10 bg-gradient-to-br from-emerald-700 to-emerald-900 rounded-full flex items-center justify-center font-bold">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="font-bold text-base">{{ $user->name }}</h2>
                <p class="text-xs text-slate-400">{{ $user->email }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('owner.users.update', $user) }}" class="space-y-4">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label" for="name">Nama Lengkap <span class="text-red-400">*</span></label>
                    <input id="name" name="name" type="text"
                        class="form-input @error('name') border-red-500 @enderror"
                        value="{{ old('name', $user->name) }}">
                    @error('name') <p class="form-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label" for="telepon">No. Telepon</label>
                    <input id="telepon" name="telepon" type="text"
                        class="form-input" value="{{ old('telepon', $user->telepon) }}">
                </div>
            </div>

            <div>
                <label class="form-label" for="email">Email <span class="text-red-400">*</span></label>
                <input id="email" name="email" type="email"
                    class="form-input @error('email') border-red-500 @enderror"
                    value="{{ old('email', $user->email) }}">
                @error('email') <p class="form-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label" for="password">
                        Password Baru
                        <span class="text-slate-500 font-normal ml-1">(kosongkan jika tidak diubah)</span>
                    </label>
                    <input id="password" name="password" type="password"
                        class="form-input @error('password') border-red-500 @enderror"
                        placeholder="Password baru...">
                    @error('password') <p class="form-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                        class="form-input" placeholder="Ulangi password baru">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label" for="role">Role / Jabatan <span class="text-red-400">*</span></label>
                    <select id="role" name="role" class="form-input">
                        <option value="manajer"    {{ old('role', $user->role) === 'manajer'    ? 'selected' : '' }}>Manajer Toko</option>
                        <option value="supervisor" {{ old('role', $user->role) === 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                        <option value="kasir"      {{ old('role', $user->role) === 'kasir'      ? 'selected' : '' }}>Kasir</option>
                        <option value="gudang"     {{ old('role', $user->role) === 'gudang'     ? 'selected' : '' }}>Pegawai Gudang</option>
                    </select>
                </div>
                <div>
                    <label class="form-label" for="cabang_id">Cabang <span class="text-red-400">*</span></label>
                    <select id="cabang_id" name="cabang_id" class="form-input">
                        @foreach ($cabang as $c)
                            <option value="{{ $c->id }}" {{ old('cabang_id', $user->cabang_id) == $c->id ? 'selected' : '' }}>{{ $c->nama_cabang }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-2.5 pt-1">
                <input id="is_active" name="is_active" type="checkbox" value="1"
                    class="w-4 h-4 accent-emerald-500 rounded"
                    {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="text-sm text-slate-300 cursor-pointer">Akun Aktif</label>
            </div>

            <div class="flex gap-3 pt-2 border-t border-dark-400">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-floppy-disk"></i> Simpan Perubahan
                </button>
                <a href="{{ route('owner.users.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
