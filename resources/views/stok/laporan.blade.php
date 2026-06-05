@extends('layouts.app')
@section('title', 'Laporan Stok')
@section('page-title', 'Laporan Stok')
@section('page-subtitle', 'Cabang: ' . $cabang->nama_cabang)

@section('content')
<div class="flex items-center justify-between mb-5">
    <div class="card flex-1 max-w-sm">
        <p class="text-xs text-slate-400 mb-1">Total Nilai Aset (Harga Beli)</p>
        <p class="text-2xl font-extrabold text-emerald-400">Rp {{ number_format($totalNilaiStok, 0, ',', '.') }}</p>
    </div>
    <a href="{{ route('manajer.stok.cetak') }}" class="btn-primary">
        <i class="fas fa-file-pdf"></i> Cetak PDF
    </a>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="table-th">#</th>
                    <th class="table-th">Kode</th>
                    <th class="table-th">Nama Produk</th>
                    <th class="table-th">Kategori</th>
                    <th class="table-th text-center">Stok Min</th>
                    <th class="table-th text-center">Stok Saat Ini</th>
                    <th class="table-th text-right">Nilai Aset (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stok as $i => $s)
                <tr class="table-tr-hover">
                    <td class="table-td text-xs text-slate-500">{{ $i + 1 }}</td>
                    <td class="table-td">
                        <code class="text-xs bg-dark-600 px-2 py-0.5 rounded">{{ $s->produk->kode_produk }}</code>
                    </td>
                    <td class="table-td font-semibold text-sm">{{ $s->produk->nama_produk }}</td>
                    <td class="table-td text-xs text-slate-400">{{ $s->produk->kategori }}</td>
                    <td class="table-td text-center text-sm">{{ $s->produk->stok_minimum }}</td>
                    <td class="table-td text-center">
                        <span class="font-bold {{ $s->jumlah <= $s->produk->stok_minimum ? 'text-red-400' : '' }}">
                            {{ $s->jumlah }}
                        </span>
                        <span class="text-xs text-slate-500">{{ $s->produk->satuan }}</span>
                    </td>
                    <td class="table-td text-right text-sm">
                        {{ number_format($s->jumlah * $s->produk->harga_beli, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-10 text-center text-slate-500">Belum ada data stok.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
