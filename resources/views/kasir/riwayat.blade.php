@extends('layouts.app')
@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')
@section('page-subtitle', 'Cabang: ' . auth()->user()->cabang->nama_cabang)

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <form method="GET" class="flex items-center gap-2">
        <input name="tanggal" type="date" value="{{ request('tanggal', today()->format('Y-m-d')) }}"
            class="form-input w-auto py-2 text-sm">
        <button type="submit" class="btn-secondary btn-sm"><i class="fas fa-filter"></i> Filter</button>
        @if(request('tanggal'))
            <a href="{{ route('kasir.riwayat') }}" class="btn-secondary btn-sm"><i class="fas fa-xmark"></i></a>
        @endif
    </form>
    <a href="{{ route('kasir.dashboard') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Transaksi Baru
    </a>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="table-th">No. Transaksi</th>
                    <th class="table-th">Kasir</th>
                    <th class="table-th">Total</th>
                    <th class="table-th">Bayar</th>
                    <th class="table-th">Status</th>
                    <th class="table-th">Waktu</th>
                    <th class="table-th">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksi as $t)
                <tr class="table-tr-hover">
                    <td class="table-td">
                        <code class="text-xs text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded">
                            {{ $t->nomor_transaksi }}
                        </code>
                    </td>
                    <td class="table-td text-sm">{{ $t->kasir->name }}</td>
                    <td class="table-td font-bold text-sm">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                    <td class="table-td text-sm text-slate-400">Rp {{ number_format($t->bayar, 0, ',', '.') }}</td>
                    <td class="table-td">
                        @if ($t->status === 'selesai')
                            <span class="badge-green">Selesai</span>
                        @else
                            <span class="badge-red">Batal</span>
                        @endif
                    </td>
                    <td class="table-td text-xs text-slate-400">{{ $t->created_at->format('H:i') }}</td>
                    <td class="table-td">
                        <a href="{{ route('kasir.transaksi.show', $t) }}" class="btn-secondary btn-sm">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-16 text-center text-slate-500">
                        <i class="fas fa-receipt text-4xl mb-3 block opacity-20"></i>
                        <p class="font-semibold text-slate-400">Belum ada transaksi</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($transaksi->hasPages())
        <div class="flex justify-center mt-4 pt-4 border-t border-dark-400">{{ $transaksi->links() }}</div>
    @endif
</div>
@endsection