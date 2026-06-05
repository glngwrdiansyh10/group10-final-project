@extends('layouts.app')
@section('title', 'Laporan Transaksi')
@section('page-title', 'Laporan Transaksi')
@section('page-subtitle', 'Cabang: ' . auth()->user()->cabang->nama_cabang)

@section('content')
<div class="card mb-5">
    <form method="GET" class="flex flex-wrap items-end gap-4">
        <div>
            <label class="form-label text-xs">Dari Tanggal</label>
            <input name="dari" type="date" value="{{ $dari }}" class="form-input w-auto py-2 text-sm">
        </div>
        <div>
            <label class="form-label text-xs">Sampai Tanggal</label>
            <input name="sampai" type="date" value="{{ $sampai }}" class="form-input w-auto py-2 text-sm">
        </div>
        <button type="submit" class="btn-primary"><i class="fas fa-filter"></i> Tampilkan</button>
        <a href="{{ route('manajer.transaksi.cetak', ['dari' => $dari, 'sampai' => $sampai]) }}"
           class="btn-secondary">
            <i class="fas fa-file-pdf"></i> Cetak PDF
        </a>
    </form>
</div>

<div class="grid grid-cols-3 gap-4 mb-5">
    <div class="stat-card">
        <div class="w-11 h-11 rounded-xl bg-emerald-500/15 flex items-center justify-center text-emerald-400 text-lg shrink-0">
            <i class="fas fa-receipt"></i>
        </div>
        <div>
            <p class="text-xs text-slate-400 mb-0.5">Total Transaksi</p>
            <p class="text-2xl font-extrabold">{{ $totalTrx }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="w-11 h-11 rounded-xl bg-blue-500/15 flex items-center justify-center text-blue-400 text-lg shrink-0">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div>
            <p class="text-xs text-slate-400 mb-0.5">Total Omzet</p>
            <p class="text-xl font-extrabold">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="w-11 h-11 rounded-xl bg-violet-500/15 flex items-center justify-center text-violet-400 text-lg shrink-0">
            <i class="fas fa-chart-simple"></i>
        </div>
        <div>
            <p class="text-xs text-slate-400 mb-0.5">Rata-rata/Transaksi</p>
            <p class="text-xl font-extrabold">Rp {{ $totalTrx > 0 ? number_format($totalOmzet / $totalTrx, 0, ',', '.') : 0 }}</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="table-th">#</th>
                    <th class="table-th">No. Transaksi</th>
                    <th class="table-th">Kasir</th>
                    <th class="table-th">Jml Item</th>
                    <th class="table-th">Total</th>
                    <th class="table-th">Status</th>
                    <th class="table-th">Tanggal & Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksi as $i => $t)
                <tr class="table-tr-hover">
                    <td class="table-td text-xs text-slate-500">{{ $i + 1 }}</td>
                    <td class="table-td">
                        <code class="text-xs text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded">{{ $t->nomor_transaksi }}</code>
                    </td>
                    <td class="table-td text-sm">{{ $t->kasir->name }}</td>
                    <td class="table-td text-center"><span class="badge-blue">{{ $t->detailTransaksi->count() }}</span></td>
                    <td class="table-td font-bold text-sm">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                    <td class="table-td">
                        <span class="{{ $t->status === 'selesai' ? 'badge-green' : 'badge-red' }}">{{ ucfirst($t->status) }}</span>
                    </td>
                    <td class="table-td text-xs text-slate-400">{{ $t->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-16 text-center text-slate-500">
                        <i class="fas fa-receipt text-4xl mb-3 block opacity-20"></i>
                        <p>Tidak ada transaksi pada periode ini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
