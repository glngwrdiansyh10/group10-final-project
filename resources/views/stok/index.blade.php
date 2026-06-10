php
@extends('layouts.app')
@section('title', 'Informasi Stok')
@section('page-title', 'Informasi Stok')
@section('page-subtitle', 'Cabang: ' . auth()->user()->cabang->nama_cabang)

@section('content')
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-5">
    <div class="stat-card">
        <div class="w-10 h-10 rounded-xl bg-blue-500/15 flex items-center justify-center text-blue-400 shrink-0">
            <i class="fas fa-boxes-stacked"></i>
        </div>
        <div>
            <p class="text-xs text-slate-400 mb-0.5">Total Item Produk</p>
            <p class="text-xl font-extrabold">{{ $stok->total() }}</p>
        </div>
    </div>
    <div class="stat-card border-red-500/30 bg-red-500/5">
        <div class="w-10 h-10 rounded-xl bg-red-500/15 flex items-center justify-center text-red-400 shrink-0">
            <i class="fas fa-triangle-exclamation"></i>
        </div>
        <div>
            <p class="text-xs text-red-400 mb-0.5">Stok Kritis</p>
            <p class="text-xl font-extrabold text-red-400">{{ $stokKritis }}</p>
        </div>
    </div>
    <div class="stat-card border-red-500/30 bg-red-500/5">
        <div class="w-10 h-10 rounded-xl bg-red-500/15 flex items-center justify-center text-red-400 shrink-0">
            <i class="fas fa-xmark"></i>
        </div>
        <div>
            <p class="text-xs text-red-400 mb-0.5">Stok Habis</p>
            <p class="text-xl font-extrabold text-red-400">{{ $stokHabis }}</p>
        </div>
    </div>
</div>

<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <form method="GET" class="flex flex-wrap items-center gap-2">
        <div class="flex items-center bg-dark-700 border border-dark-500 rounded-lg px-3 gap-2">
            <i class="fas fa-search text-slate-500 text-xs"></i>
            <input name="search" type="text" placeholder="Cari nama / kode..." value="{{ request('search') }}"
                class="bg-transparent py-2 text-sm text-slate-200 placeholder-slate-500 outline-none w-40">
        </div>
        <select name="kategori" class="form-input w-auto py-2 text-sm">
            <option value="">Semua Kategori</option>
            @foreach ($kategori as $k)
                <option value="{{ $k }}" {{ request('kategori') === $k ? 'selected' : '' }}>{{ $k }}</option>
            @endforeach
        </select>
        <select name="filter" class="form-input w-auto py-2 text-sm">
            <option value="">Semua Kondisi</option>
            <option value="kritis" {{ request('filter') === 'kritis' ? 'selected' : '' }}>Stok Kritis</option>
            <option value="habis"  {{ request('filter') === 'habis'  ? 'selected' : '' }}>Stok Habis</option>
        </select>
        <button type="submit" class="btn-secondary btn-sm"><i class="fas fa-filter"></i></button>
        @if(request()->anyFilled(['search','kategori','filter']))
            <a href="{{ route('gudang.dashboard') }}" class="btn-secondary btn-sm"><i class="fas fa-xmark"></i></a>
        @endif
    </form>
    <div class="flex gap-2">
        <a href="{{ route('gudang.mutasi.index') }}" class="btn-secondary">
            <i class="fas fa-clock-rotate-left"></i> Riwayat Mutasi
        </a>
        <a href="{{ route('gudang.mutasi.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Input Mutasi
        </a>
    </div>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="table-th">Kode</th>
                    <th class="table-th">Nama Produk</th>
                    <th class="table-th">Kategori</th>
                    <th class="table-th text-center">Stok Min</th>
                    <th class="table-th text-center">Stok Tersedia</th>
                    <th class="table-th">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stok as $s)
                <tr class="table-tr-hover">
                    <td class="table-td">
                        <code class="text-xs bg-dark-600 text-slate-300 px-2 py-0.5 rounded">{{ $s->produk->kode_produk }}</code>
                    </td>
                    <td class="table-td font-semibold text-sm">{{ $s->produk->nama_produk }}</td>
                    <td class="table-td"><span class="badge-blue">{{ $s->produk->kategori }}</span></td>
                    <td class="table-td text-center text-sm text-slate-400">{{ $s->produk->stok_minimum }}</td>
                    <td class="table-td text-center font-bold text-base">
                        {{ $s->jumlah }} <span class="text-xs font-normal text-slate-400">{{ $s->produk->satuan }}</span>
                    </td>
                    <td class="table-td">
                        @if ($s->jumlah == 0)
                            <span class="badge-red"><i class="fas fa-xmark text-[10px]"></i> Habis</span>
                        @elseif ($s->jumlah <= $s->produk->stok_minimum)
                            <span class="badge-orange"><i class="fas fa-triangle-exclamation text-[10px]"></i> Kritis</span>
                        @else
                            <span class="badge-green"><i class="fas fa-check text-[10px]"></i> Aman</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-16 text-center text-slate-500">
                        <i class="fas fa-box-open text-4xl mb-3 block opacity-20"></i>
                        <p>Belum ada data stok produk.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($stok->hasPages())
        <div class="flex justify-center mt-4 pt-4 border-t border-dark-400">{{ $stok->links() }}</div>
    @endif
</div>
@endsection