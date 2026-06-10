php
@extends('layouts.app')
@section('title', 'Laporan Stok')
@section('page-title', 'Laporan Stok')
@section('page-subtitle', 'Cabang: ' . ($cabang->nama_cabang ?? '-'))

@section('content')
<div class="flex items-center justify-between mb-5">
    <div>
        <p class="text-sm text-slate-400">
            Total nilai stok:
            <span class="font-bold text-emerald-400">Rp {{ number_format($totalNilaiStok, 0, ',', '.') }}</span>
        </p>
    </div>
    <a href="{{ route('manajer.stok.cetak') }}" class="btn-primary" target="_blank">
        <i class="fas fa-file-pdf"></i> Cetak PDF
    </a>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="table-th">Kode</th>
                    <th class="table-th">Nama Produk</th>
                    <th class="table-th">Kategori</th>
                    <th class="table-th text-center">Stok</th>
                    <th class="table-th">Satuan</th>
                    <th class="table-th text-right">Harga Beli</th>
                    <th class="table-th text-right">Nilai Stok</th>
                    <th class="table-th text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @php $currentKategori = null; @endphp
                @forelse ($stok as $s)
                @if ($currentKategori !== $s->produk->kategori)
                    @php $currentKategori = $s->produk->kategori; @endphp
                    <tr>
                        <td colspan="8" class="px-4 py-2 text-xs font-bold text-slate-400 uppercase tracking-widest bg-dark-700">
                            {{ $currentKategori }}
                        </td>
                    </tr>
                @endif
                <tr class="table-tr-hover">
                    <td class="table-td"><code class="text-xs text-slate-400">{{ $s->produk->kode_produk }}</code></td>
                    <td class="table-td font-semibold text-sm">{{ $s->produk->nama_produk }}</td>
                    <td class="table-td text-sm text-slate-400">{{ $s->produk->kategori }}</td>
                    <td class="table-td text-center font-bold">{{ $s->jumlah }}</td>
                    <td class="table-td text-sm text-slate-400">{{ $s->produk->satuan }}</td>
                    <td class="table-td text-right text-sm">Rp {{ number_format($s->produk->harga_beli, 0, ',', '.') }}</td>
                    <td class="table-td text-right font-bold text-sm">
                        Rp {{ number_format($s->jumlah * $s->produk->harga_beli, 0, ',', '.') }}
                    </td>
                    <td class="table-td text-center">
                        @if ($s->jumlah == 0)
                            <span class="badge-red">Habis</span>
                        @elseif ($s->jumlah <= $s->produk->stok_minimum)
                            <span class="badge-orange">Kritis</span>
                        @else
                            <span class="badge-green">Aman</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="py-12 text-center text-slate-500">Tidak ada data stok.</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="border-t-2 border-dark-400">
                    <td colspan="6" class="px-4 py-3 text-right font-bold text-sm">Total Nilai Stok:</td>
                    <td class="px-4 py-3 text-right font-extrabold text-emerald-400">
                        Rp {{ number_format($totalNilaiStok, 0, ',', '.') }}
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection