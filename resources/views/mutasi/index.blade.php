php
@extends('layouts.app')
@section('title', 'Riwayat Mutasi Stok')
@section('page-title', 'Riwayat Mutasi Stok')
@section('page-subtitle', 'Cabang: ' . auth()->user()->cabang->nama_cabang)

@section('content')

<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <form method="GET" class="flex flex-wrap items-center gap-2">
        <select name="tipe" class="form-input w-auto py-2 text-sm">
            <option value="">Semua Tipe</option>
            <option value="masuk"  {{ request('tipe') === 'masuk'  ? 'selected' : '' }}>Stok Masuk</option>
            <option value="keluar" {{ request('tipe') === 'keluar' ? 'selected' : '' }}>Stok Keluar</option>
        </select>
        <input name="tanggal" type="date" value="{{ request('tanggal') }}"
            class="form-input w-auto py-2 text-sm">
        <button type="submit" class="btn-secondary btn-sm"><i class="fas fa-filter"></i> Filter</button>
        @if(request()->anyFilled(['tipe','tanggal']))
            <a href="{{ route('gudang.mutasi.index') }}" class="btn-secondary btn-sm"><i class="fas fa-xmark"></i> Reset</a>
        @endif
    </form>
    <a href="{{ route('gudang.mutasi.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Input Mutasi
    </a>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="table-th">Tanggal</th>
                    <th class="table-th">Produk</th>
                    <th class="table-th text-center">Tipe</th>
                    <th class="table-th text-center">Jumlah</th>
                    <th class="table-th">Petugas</th>
                    <th class="table-th">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mutasi as $m)
                <tr class="table-tr-hover">
                    <td class="table-td text-xs text-slate-400">
                        {{ $m->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="table-td">
                        <p class="font-semibold text-sm">{{ $m->produk->nama_produk }}</p>
                        <p class="text-xs text-slate-500">{{ $m->produk->kode_produk }}</p>
                    </td>
                    <td class="table-td text-center">
                        @if ($m->tipe === 'masuk')
                            <span class="badge-green"><i class="fas fa-arrow-up text-[10px]"></i> Masuk</span>
                        @else
                            <span class="badge-red"><i class="fas fa-arrow-down text-[10px]"></i> Keluar</span>
                        @endif
                    </td>
                    <td class="table-td text-center font-bold text-base">
                        {{ $m->tipe === 'masuk' ? '+' : '-' }}{{ $m->jumlah }}
                    </td>
                    <td class="table-td text-sm">{{ $m->user->name ?? '-' }}</td>
                    <td class="table-td text-sm text-slate-400 max-w-xs truncate">{{ $m->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-16 text-center text-slate-500">
                        <i class="fas fa-clock-rotate-left text-4xl mb-3 block opacity-20"></i>
                        <p>Belum ada riwayat mutasi stok.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($mutasi->hasPages())
        <div class="flex justify-center mt-4 pt-4 border-t border-dark-400">{{ $mutasi->links() }}</div>
    @endif
</div>
@endsection