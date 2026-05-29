@extends('layouts.app')
@section('title', 'Manajemen Cabang')
@section('page-title', 'Manajemen Cabang')
@section('page-subtitle', 'Kelola semua cabang Jay-Mart')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-extrabold">Daftar Cabang</h1>
        <p class="text-sm text-slate-400 mt-0.5">Total {{ $cabang->count() }} cabang terdaftar</p>
    </div>
    <a href="{{ route('owner.cabang.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Tambah Cabang
    </a>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="table-th">#</th>
                    <th class="table-th">Nama Cabang</th>
                    <th class="table-th">Kota</th>
                    <th class="table-th">Alamat</th>
                    <th class="table-th">Telepon</th>
                    <th class="table-th">Pegawai</th>
                    <th class="table-th">Status</th>
                    <th class="table-th">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cabang as $i => $c)
                <tr class="table-tr-hover">
                    <td class="table-td text-slate-500 text-xs">{{ $i + 1 }}</td>
                    <td class="table-td">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 bg-emerald-500/15 rounded-lg flex items-center justify-center text-emerald-400 shrink-0">
                                <i class="fas fa-store text-xs"></i>
                            </div>
                            <span class="font-semibold text-sm">{{ $c->nama_cabang }}</span>
                        </div>
                    </td>
                    <td class="table-td text-sm">{{ $c->kota }}</td>
                    <td class="table-td text-xs text-slate-400 max-w-xs truncate">{{ $c->alamat }}</td>
                    <td class="table-td text-sm">{{ $c->telepon ?? '-' }}</td>
                    <td class="table-td">
                        <span class="badge-blue">{{ $c->users_count }} orang</span>
                    </td>
                    <td class="table-td">
                        @if ($c->is_active)
                            <span class="badge-green"><i class="fas fa-circle text-[7px]"></i> Aktif</span>
                        @else
                            <span class="badge-red"><i class="fas fa-circle text-[7px]"></i> Nonaktif</span>
                        @endif
                    </td>
                    <td class="table-td">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('owner.cabang.edit', $c) }}"
                               class="btn-secondary btn-sm">
                                <i class="fas fa-pen-to-square"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('owner.cabang.destroy', $c) }}"
                                  onsubmit="return confirm('Hapus cabang ini?')">
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
                    <td colspan="8" class="py-16 text-center text-slate-500">
                        <i class="fas fa-store-slash text-4xl mb-3 block opacity-20"></i>
                        <p class="font-semibold text-slate-400">Belum ada cabang</p>
                        <a href="{{ route('owner.cabang.create') }}" class="btn-primary mt-4 inline-flex">
                            <i class="fas fa-plus"></i> Tambah Cabang Pertama
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
