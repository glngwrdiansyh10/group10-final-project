@extends('layouts.app')
@section('title', 'Dashboard Manajer')
@section('page-title', 'Dashboard Manajer')
@section('page-subtitle', 'Cabang: ' . ($cabang->nama_cabang ?? '-'))

@section('content')

{{-- ── STATS GRID ──────────────────────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    <div class="stat-card">
        <div class="w-11 h-11 rounded-xl bg-emerald-500/15 flex items-center justify-center text-emerald-400 text-lg shrink-0">
            <i class="fas fa-receipt"></i>
        </div>
        <div>
            <p class="text-xs text-slate-400 mb-0.5">Transaksi Hari Ini</p>
            <p class="text-2xl font-extrabold">{{ number_format($transaksiHariIni) }}</p>
            <p class="text-xs text-slate-500 mt-0.5">{{ $cabang->nama_cabang }}</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="w-11 h-11 rounded-xl bg-blue-500/15 flex items-center justify-center text-blue-400 text-lg shrink-0">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div>
            <p class="text-xs text-slate-400 mb-0.5">Omzet Hari Ini</p>
            <p class="text-xl font-extrabold leading-tight">Rp {{ number_format($omzetHariIni, 0, ',', '.') }}</p>
            <p class="text-xs text-slate-500 mt-0.5">{{ now()->translatedFormat('d F Y') }}</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="w-11 h-11 rounded-xl bg-violet-500/15 flex items-center justify-center text-violet-400 text-lg shrink-0">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div>
            <p class="text-xs text-slate-400 mb-0.5">Omzet Bulan Ini</p>
            <p class="text-xl font-extrabold leading-tight">Rp {{ number_format($omzetBulanIni, 0, ',', '.') }}</p>
            <p class="text-xs text-slate-500 mt-0.5">{{ now()->format('F Y') }}</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="w-11 h-11 rounded-xl bg-red-500/15 flex items-center justify-center text-red-400 text-lg shrink-0">
            <i class="fas fa-triangle-exclamation"></i>
        </div>
        <div>
            <p class="text-xs text-slate-400 mb-0.5">Stok Kritis</p>
            <p class="text-2xl font-extrabold">{{ $stokKritis }}</p>
            <p class="text-xs text-slate-500 mt-0.5">{{ $stokHabis }} item habis</p>
        </div>
    </div>

</div>

{{-- ── CHART + AKSI CEPAT ───────────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">

    {{-- Chart Omzet 7 Hari --}}
    <div class="card lg:col-span-2">
        <div class="flex items-start justify-between mb-4 pb-3.5 border-b border-dark-400">
            <div>
                <h3 class="font-bold text-sm">Omzet 7 Hari Terakhir</h3>
                <p class="text-xs text-slate-400 mt-0.5">{{ $cabang->nama_cabang }}</p>
            </div>
        </div>
        <div class="relative h-52">
            <canvas id="omzetChart"></canvas>
        </div>
    </div>

    {{-- Aksi Cepat --}}
    <div class="card flex flex-col gap-3">
        <div class="pb-3.5 border-b border-dark-400 mb-1">
            <h3 class="font-bold text-sm">Aksi Cepat</h3>
            <p class="text-xs text-slate-400 mt-0.5">Kelola laporan cabang</p>
        </div>

        <a href="{{ route('manajer.transaksi.laporan') }}"
            class="flex items-center gap-3 p-3 bg-dark-800 border border-dark-500 rounded-xl hover:border-emerald-500 hover:bg-emerald-500/5 transition-all duration-200 group">
            <div class="w-9 h-9 bg-emerald-500/15 rounded-lg flex items-center justify-center text-emerald-400 group-hover:bg-emerald-500/25 transition-colors">
                <i class="fas fa-file-lines text-sm"></i>
            </div>
            <div>
                <p class="text-sm font-semibold">Laporan Transaksi</p>
                <p class="text-xs text-slate-500">Filter & export PDF</p>
            </div>
        </a>

        <a href="{{ route('manajer.stok.laporan') }}"
            class="flex items-center gap-3 p-3 bg-dark-800 border border-dark-500 rounded-xl hover:border-blue-500 hover:bg-blue-500/5 transition-all duration-200 group">
            <div class="w-9 h-9 bg-blue-500/15 rounded-lg flex items-center justify-center text-blue-400 group-hover:bg-blue-500/25 transition-colors">
                <i class="fas fa-boxes-stacking text-sm"></i>
            </div>
            <div>
                <p class="text-sm font-semibold">Laporan Stok</p>
                <p class="text-xs text-slate-500">Cek & cetak stok cabang</p>
            </div>
        </a>

        @if($stokKritis > 0)
        <div class="flex items-center gap-3 p-3 bg-red-500/8 border border-red-500/25 rounded-xl">
            <div class="w-9 h-9 bg-red-500/15 rounded-lg flex items-center justify-center text-red-400">
                <i class="fas fa-triangle-exclamation text-sm"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-red-300">{{ $stokKritis }} Produk Kritis</p>
                <p class="text-xs text-slate-500">Segera hubungi gudang</p>
            </div>
        </div>
        @endif

        @if($stokHabis > 0)
        <div class="flex items-center gap-3 p-3 bg-amber-500/8 border border-amber-500/25 rounded-xl">
            <div class="w-9 h-9 bg-amber-500/15 rounded-lg flex items-center justify-center text-amber-400">
                <i class="fas fa-box-open text-sm"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-amber-300">{{ $stokHabis }} Produk Habis</p>
                <p class="text-xs text-slate-500">Stok = 0, perlu restock</p>
            </div>
        </div>
        @endif
    </div>

</div>

{{-- ── TRANSAKSI TERBARU ────────────────────────────────────────── --}}
<div class="card auto-refresh" id="dashboard-manajer-transaksi">
    <div class="flex items-start justify-between mb-4 pb-3.5 border-b border-dark-400">
        <div>
            <h3 class="font-bold text-sm">Transaksi Terbaru</h3>
            <p class="text-xs text-slate-400 mt-0.5">6 transaksi terakhir — {{ $cabang->nama_cabang }}</p>
        </div>
        <a href="{{ route('manajer.transaksi.laporan') }}" class="btn-secondary btn-sm">
            <i class="fas fa-list"></i> Lihat Semua
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="table-th">No. Transaksi</th>
                    <th class="table-th">Kasir</th>
                    <th class="table-th">Total</th>
                    <th class="table-th">Status</th>
                    <th class="table-th">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksiTerbaru as $t)
                <tr class="table-tr-hover">
                    <td class="table-td">
                        <code class="text-xs text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded">
                            {{ $t->nomor_transaksi }}
                        </code>
                    </td>
                    <td class="table-td text-sm">{{ $t->kasir->name ?? '-' }}</td>
                    <td class="table-td font-bold text-sm">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                    <td class="table-td">
                        @if ($t->status === 'selesai')
                            <span class="badge-green">Selesai</span>
                        @else
                            <span class="badge-red">Batal</span>
                        @endif
                    </td>
                    <td class="table-td text-xs text-slate-400">{{ $t->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-14 text-center text-slate-500 text-sm">
                        <i class="fas fa-receipt text-4xl mb-3 block opacity-20"></i>
                        <p class="font-semibold text-slate-400">Belum ada transaksi hari ini</p>
                        <p class="text-xs mt-1">Transaksi akan muncul setelah kasir melakukan penjualan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
new Chart(document.getElementById('omzetChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($chartLabels) !!},
        datasets: [{
            label: 'Omzet',
            data: {!! json_encode($chartData) !!},
            borderColor: '#10b981',
            backgroundColor: 'rgba(16,185,129,0.08)',
            borderWidth: 2.5,
            pointBackgroundColor: '#10b981',
            pointRadius: 4,
            tension: 0.4,
            fill: true,
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: c => 'Rp ' + c.parsed.y.toLocaleString('id-ID') } }
        },
        scales: {
            x: { grid: { color: 'rgba(255,255,255,0.04)' }, ticks: { color: '#64748b', font: { size: 11 } } },
            y: { grid: { color: 'rgba(255,255,255,0.04)' }, ticks: { color: '#64748b', font: { size: 11 }, callback: v => 'Rp ' + (v/1000).toFixed(0) + 'k' } }
        }
    }
});
</script>
@endpush
