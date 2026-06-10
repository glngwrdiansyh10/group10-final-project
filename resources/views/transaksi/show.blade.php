@extends('layouts.app')
@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')
@section('page-subtitle', $transaksi->nomor_transaksi)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-5">
        <a href="javascript:history.back()" class="btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card mb-4">
        <h3 class="font-bold text-sm mb-4 pb-3 border-b border-dark-400">Informasi Transaksi</h3>
        <div class="grid grid-cols-2 gap-3 text-sm">
            <div>
                <p class="text-xs text-slate-400 mb-0.5">No. Transaksi</p>
                <code class="text-emerald-400 text-xs">{{ $transaksi->nomor_transaksi }}</code>
            </div>
            <div>
                <p class="text-xs text-slate-400 mb-0.5">Status</p>
                <span class="{{ $transaksi->status === 'selesai' ? 'badge-green' : 'badge-red' }}">{{ ucfirst($transaksi->status) }}</span>
            </div>
            <div>
                <p class="text-xs text-slate-400 mb-0.5">Tanggal & Waktu</p>
                <p class="font-semibold">{{ $transaksi->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400 mb-0.5">Kasir</p>
                <p class="font-semibold">{{ $transaksi->kasir->name }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400 mb-0.5">Cabang</p>
                <p class="font-semibold">{{ $transaksi->cabang->nama_cabang }}</p>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <h3 class="font-bold text-sm mb-4 pb-3 border-b border-dark-400">Detail Item</h3>
        <div class="space-y-3">
            @foreach ($transaksi->detailTransaksi as $d)
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-semibold">{{ $d->produk->nama_produk }}</p>
                    <p class="text-xs text-slate-400">{{ $d->jumlah }} x Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</p>
                </div>
                <p class="font-bold text-sm">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</p>
            </div>
            @endforeach
        </div>
        <div class="border-t border-dark-400 mt-4 pt-4 space-y-2">
            <div class="flex justify-between text-lg font-extrabold">
                <span class="text-emerald-400">TOTAL</span>
                <span class="text-emerald-400">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm text-slate-400">
                <span>Dibayar</span>
                <span>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm text-slate-400">
                <span>Kembalian</span>
                <span>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection