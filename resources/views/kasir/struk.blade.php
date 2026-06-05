@extends('layouts.app')
@section('title', 'Struk Transaksi')
@section('page-title', 'Struk Transaksi')
@section('page-subtitle', $transaksi->nomor_transaksi)

@section('content')
<div class="max-w-sm mx-auto">

    <div class="flex gap-3 mb-5">
        <a href="{{ route('kasir.dashboard') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Transaksi Baru
        </a>
        <button onclick="window.print()" class="btn-secondary">
            <i class="fas fa-print"></i> Cetak Struk
        </button>
    </div>

    {{-- Struk --}}
    <div class="card text-center" id="struk">
        <div class="mb-4 pb-4 border-b border-dashed border-dark-400">
            <p class="text-2xl font-extrabold">🏪 Jay-Mart</p>
            <p class="text-sm text-slate-400">{{ $transaksi->cabang->nama_cabang }}</p>
            <p class="text-xs text-slate-500">{{ $transaksi->cabang->alamat }}</p>
        </div>

        <div class="text-xs text-slate-400 mb-3 space-y-1 text-left">
            <div class="flex justify-between">
                <span>No. Transaksi</span>
                <span class="font-mono text-emerald-400">{{ $transaksi->nomor_transaksi }}</span>
            </div>
            <div class="flex justify-between">
                <span>Tanggal</span>
                <span>{{ $transaksi->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Kasir</span>
                <span>{{ $transaksi->kasir->name }}</span>
            </div>
        </div>

        <div class="border-t border-dashed border-dark-400 pt-3 mb-3">
            @foreach ($transaksi->detailTransaksi as $d)
            <div class="flex justify-between text-xs mb-2">
                <div class="text-left">
                    <p class="font-semibold text-slate-200">{{ $d->produk->nama_produk }}</p>
                    <p class="text-slate-500">{{ $d->jumlah }} × Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</p>
                </div>
                <span class="font-semibold">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</span>
            </div>
            @endforeach
        </div>

        <div class="border-t border-dashed border-dark-400 pt-3 space-y-1 text-sm">
            <div class="flex justify-between font-bold text-base">
                <span>TOTAL</span>
                <span class="text-emerald-400">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-slate-400 text-xs">
                <span>Bayar</span>
                <span>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-slate-400 text-xs">
                <span>Kembalian</span>
                <span>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="mt-4 pt-4 border-t border-dashed border-dark-400">
            <p class="text-xs text-slate-500">Terima kasih telah berbelanja!</p>
            <p class="text-xs text-slate-600">Jay-Mart — Belanja Mudah, Harga Bersahabat</p>
        </div>
    </div>
</div>

@push('styles')
<style>
@media print {
    .sidebar, .topbar, .btn-primary, .btn-secondary { display: none !important; }
    .main-content { margin-left: 0 !important; }
    #struk { background: white; color: black; border: none; box-shadow: none; }
    #struk * { color: black !important; }
}
</style>
@endpush
@endsection
