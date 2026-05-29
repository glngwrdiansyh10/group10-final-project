@extends('layouts.app')
@section('title', 'Manajemen Pegawai')
@section('page-title', 'Manajemen Pegawai')
@section('page-subtitle', 'Kelola akun semua pegawai Jay-Mart')

@section('content')

{{-- Filter Bar --}}
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <form method="GET" class="flex flex-wrap gap-2 items-center">
        <div class="flex items-center bg-dark-700 border border-dark-500 rounded-lg px-3 gap-2">
            <i class="fas fa-search text-slate-500 text-xs"></i>
            <input name="search" type="text" placeholder="Cari nama / email..."
                value="{{ request('search') }}"
                class="bg-transparent py-2 text-sm text-slate-200 placeholder-slate-500 outline-none w-48">
        </div>
        <select name="cabang_id" class="form-input w-auto py-2 text-sm">
            <option value="">Semua Cabang</option>
            @foreach ($cabang as $c)
                <option value="{{ $c->id }}" {{ request('cabang_id') == $c->id ? 'selected' : '' }}>{{ $c->nama_cabang }}</option>
            @endforeach
        </select>
        <select name="role" class="form-input w-auto py-2 text-sm">
            <option value="">Semua Role</option>
            <option value="manajer"    {{ request('role') === 'manajer'    ? 'selected' : '' }}>Manajer</option>
            <option value="supervisor" {{ request('role') === 'supervisor' ? 'selected' : '' }}>Supervisor</option>
            <option value="kasir"      {{ request('role') === 'kasir'      ? 'selected' : '' }}>Kasir</option>
            <option value="gudang"     {{ request('role') === 'gudang'     ? 'selected' : '' }}>Gudang</option>
        </select>
        <button type="submit" class="btn-secondary btn-sm">
            <i class="fas fa-filter"></i> Filter
        </button>
        @if(request()->anyFilled(['search','cabang_id','role']))
            <a href="{{ route('owner.users.index') }}" class="btn-secondary btn-sm">
                <i class="fas fa-xmark"></i> Reset
            </a>
        @endif
    </form>
    <a href="{{ route('owner.users.create') }}" class="btn-primary">
        <i class="fas fa-user-plus"></i> Tambah Pegawai
    </a>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="table-th">#</th>
                    <th class="table-th">Nama</th>
                    <th class="table-th">Email</th>
                    <th class="table-th">Role</th>
                    <th class="table-th">Cabang</th>
                    <th class="table-th">Status</th>
                    <th class="table-th">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $i => $u)
                <tr class="table-tr-hover">
                    <td class="table-td text-xs text-slate-500">{{ $users->firstItem() + $i }}</td>
                    <td class="table-td">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 bg-gradient-to-br from-emerald-700 to-emerald-900 rounded-full flex items-center justify-center text-xs font-bold shrink-0">
                                {{ strtoupper(substr($u->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-sm">{{ $u->name }}</p>
                                <p class="text-xs text-slate-500">{{ $u->telepon ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="table-td text-sm text-slate-300">{{ $u->email }}</td>
                    <td class="table-td">
                        @php
                            $roleColor = match($u->role) {
                                'manajer'    => 'badge-purple',
                                'supervisor' => 'badge-blue',
                                'kasir'      => 'badge-orange',
                                'gudang'     => 'badge-gray',
                                default      => 'badge-gray',
                            };
                        @endphp
                        <span class="{{ $roleColor }}">{{ $u->role_label }}</span>
                    </td>
                    <td class="table-td text-sm">{{ $u->cabang->nama_cabang ?? '-' }}</td>
                    <td class="table-td">
                        <form method="POST" action="{{ route('owner.users.toggle-active', $u) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="{{ $u->is_active ? 'badge-green' : 'badge-red' }} cursor-pointer hover:opacity-80 transition-opacity border-none">
                                <i class="fas fa-circle text-[7px]"></i>
                                {{ $u->is_active ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>
                    </td>
                    <td class="table-td">
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('owner.users.edit', $u) }}" class="btn-secondary btn-sm">
                                <i class="fas fa-pen-to-square"></i>
                            </a>
                            <form method="POST" action="{{ route('owner.users.destroy', $u) }}"
                                  onsubmit="return confirm('Hapus pegawai {{ $u->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-16 text-center text-slate-500">
                        <i class="fas fa-users-slash text-4xl mb-3 block opacity-20"></i>
                        <p class="font-semibold text-slate-400">Belum ada pegawai</p>
                        <a href="{{ route('owner.users.create') }}" class="btn-primary mt-4 inline-flex">
                            <i class="fas fa-user-plus"></i> Tambah Pegawai
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($users->hasPages())
    <div class="flex justify-center mt-5 pt-4 border-t border-dark-400">
        {{ $users->links() }}
    </div>
    @endif
</div>

@endsection
