@extends('layouts.app')
@section('title', 'Dashboard Supervisor')
@section('page-title', 'Dashboard Supervisor')
@section('page-subtitle', 'Cabang: ' . ($cabang->nama_cabang ?? '-'))

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
    <div class="stat-card">
        <div class="w-11 h-11 rounded-xl bg-emerald-500/15 flex items-center justify-center text-emerald-400 text-lg shrink-0">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div>
            <p class="text-xs text-slate-400 mb-0.5">Omzet Hari Ini</p>
            <p class="text-xl font-extrabold">Rp {{ number_format($omzetHariIni, 0, ',', '.') }}</p>
            <p class="text-xs text-slate-500 mt-0.5">{{ $cabang->nama_cabang }}</p>
        </div>
    </div>
    <div class="stat-card border-red-500/30">
        <div class="w-11 h-11 rounded-xl bg-red-500/15 flex items-center justify-center text-red-400 text-lg shrink-0">
            <i class="fas fa-triangle-exclamation"></i>
        </div>
        <div>
            <p class="text-xs text-red-400 mb-0.5">Stok Perlu Perhatian</p>
            <p class="text-xl font-extrabold text-red-400">{{ $stokKritis->count() + $stokHabis->count() }}</p>
            <p class="text-xs text-slate-500 mt-0.5">{{ $stokHabis->count() }} habis, {{ $stokKritis->count() }} kritis</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
    {{-- Transaksi Hari Ini --}}
    <div class="card auto-refresh" id="dashboard-supervisor-transaksi">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-dark-400">
            <h3 class="font-bold text-sm">Transaksi Hari Ini</h3>
            <span class="badge-blue">{{ $transaksiHariIni->count() }} trx</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="table-th">No. Transaksi</th>
                        <th class="table-th">Kasir</th>
                        <th class="table-th">Total</th>
                        <th class="table-th">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksiHariIni as $t)
                    <tr class="table-tr-hover">
                        <td class="table-td"><code class="text-xs text-emerald-400">{{ $t->nomor_transaksi }}</code></td>
                        <td class="table-td text-sm">{{ $t->kasir->name ?? '-' }}</td>
                        <td class="table-td font-bold text-sm">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                        <td class="table-td text-xs text-slate-400">{{ $t->created_at->format('H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="py-8 text-center text-slate-500 text-sm">Belum ada transaksi hari ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Stok Kritis/Habis --}}
    <div class="card">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-dark-400">
            <h3 class="font-bold text-sm">Stok Perlu Perhatian</h3>
        </div>
        <div class="space-y-2">
            @foreach ($stokHabis as $s)
            <div class="flex items-center justify-between p-3 bg-red-500/8 border border-red-500/25 rounded-lg">
                <div>
                    <p class="text-sm font-semibold">{{ $s->produk->nama_produk }}</p>
                    <p class="text-xs text-slate-500">{{ $s->produk->kode_produk }}</p>
                </div>
                <span class="badge-red">HABIS</span>
            </div>
            @endforeach
            @forelse ($stokKritis as $s)
            <div class="flex items-center justify-between p-3 bg-amber-500/8 border border-amber-500/25 rounded-lg">
                <div>
                    <p class="text-sm font-semibold">{{ $s->produk->nama_produk }}</p>
                    <p class="text-xs text-slate-500">Sisa: {{ $s->jumlah }} {{ $s->produk->satuan }}</p>
                </div>
                <span class="badge-orange">KRITIS</span>
            </div>
            @empty
            @if($stokHabis->isEmpty())
            <p class="text-center text-slate-500 text-sm py-8"><i class="fas fa-check-circle text-emerald-400"></i> Semua stok aman!</p>
            @endif
            @endforelse
        </div>
    </div>
</div>
@endsection
