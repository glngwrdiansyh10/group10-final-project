@extends('layouts.app')
@section('title', 'Dashboard Owner')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . auth()->user()->name . '! Pantau semua cabang Jay-Mart.')

@section('content')

{{-- ── STATS GRID ──────────────────────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">

    <div class="stat-card">
        <div class="w-11 h-11 rounded-xl bg-emerald-500/15 flex items-center justify-center text-emerald-400 text-lg shrink-0">
            <i class="fas fa-receipt"></i>
        </div>
        <div>
            <p class="text-xs text-slate-400 mb-0.5">Transaksi Hari Ini</p>
            <p class="text-2xl font-extrabold">{{ number_format($totalTransaksiHariIni) }}</p>
            <p class="text-xs text-slate-500 mt-0.5">Semua cabang</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="w-11 h-11 rounded-xl bg-blue-500/15 flex items-center justify-center text-blue-400 text-lg shrink-0">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div>
            <p class="text-xs text-slate-400 mb-0.5">Omzet Hari Ini</p>
            <p class="text-xl font-extrabold leading-tight">Rp {{ number_format($omzetHariIni, 0, ',', '.') }}</p>
            <p class="text-xs text-slate-500 mt-0.5">Semua cabang</p>
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
        <div class="w-11 h-11 rounded-xl bg-amber-500/15 flex items-center justify-center text-amber-400 text-lg shrink-0">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <p class="text-xs text-slate-400 mb-0.5">Pegawai Aktif</p>
            <p class="text-2xl font-extrabold">{{ $totalPegawai }}</p>
            <p class="text-xs text-slate-500 mt-0.5">Semua cabang</p>
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

{{-- ── CHART + RINGKASAN CABANG ─────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">

    {{-- Chart --}}
    <div class="card">
        <div class="flex items-start justify-between mb-4 pb-3.5 border-b border-dark-400">
            <div>
                <h3 class="font-bold text-sm">Omzet 7 Hari Terakhir</h3>
                <p class="text-xs text-slate-400 mt-0.5">Semua cabang gabungan</p>
            </div>
        </div>
        <div class="relative h-52">
            <canvas id="omzetChart"></canvas>
        </div>
    </div>

    {{-- Ringkasan Cabang --}}
    <div class="card">
        <div class="flex items-start justify-between mb-4 pb-3.5 border-b border-dark-400">
            <div>
                <h3 class="font-bold text-sm">Ringkasan Cabang</h3>
                <p class="text-xs text-slate-400 mt-0.5">Performa hari ini</p>
            </div>
            <a href="{{ route('owner.cabang.index') }}" class="btn-secondary btn-sm">
                <i class="fas fa-store"></i> Kelola
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="table-th">Cabang</th>
                        <th class="table-th">Trx</th>
                        <th class="table-th">Omzet</th>
                        <th class="table-th">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cabangList as $c)
                    <tr class="table-tr-hover">
                        <td class="table-td">
                            <p class="font-semibold text-sm">{{ $c->nama_cabang }}</p>
                            <p class="text-xs text-slate-500">{{ $c->kota }}</p>
                        </td>
                        <td class="table-td font-bold">{{ $c->transaksi_hari_ini }}</td>
                        <td class="table-td text-xs">Rp {{ number_format($c->omzet_hari_ini, 0, ',', '.') }}</td>
                        <td class="table-td">
                            @if ($c->is_active)
                                <span class="badge-green"><i class="fas fa-circle text-[7px]"></i> Aktif</span>
                            @else
                                <span class="badge-red"><i class="fas fa-circle text-[7px]"></i> Nonaktif</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-10 text-center text-slate-500 text-sm">
                            <i class="fas fa-store-slash text-3xl mb-2 block opacity-30"></i>
                            Belum ada data cabang
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ── TRANSAKSI TERBARU ─────────────────────────────────────────── --}}
<div class="card auto-refresh" id="dashboard-owner-transaksi">
    <div class="flex items-start justify-between mb-4 pb-3.5 border-b border-dark-400">
        <div>
            <h3 class="font-bold text-sm">Transaksi Terbaru</h3>
            <p class="text-xs text-slate-400 mt-0.5">8 transaksi terbaru dari semua cabang</p>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="table-th">No. Transaksi</th>
                    <th class="table-th">Cabang</th>
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
                    <td class="table-td text-sm">{{ $t->cabang->nama_cabang ?? '-' }}</td>
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
                    <td colspan="6" class="py-14 text-center text-slate-500 text-sm">
                        <i class="fas fa-receipt text-4xl mb-3 block opacity-20"></i>
                        <p class="font-semibold text-slate-400">Belum ada transaksi</p>
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
