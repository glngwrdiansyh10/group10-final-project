@extends('layouts.app')
@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')
@section('page-subtitle', $transaksi->nomor_transaksi)

@section('content')
<div class="max-w-3xl">
    <div class="flex gap-3 mb-5">
        <a href="javascript:history.back()" class="btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('kasir.struk', $transaksi) }}" class="btn-primary btn-sm">
            <i class="fas fa-receipt"></i> Lihat Struk
        </a>
    </div>

    <div class="card mb-5">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div>
                <p class="text-xs text-slate-400 mb-1">No. Transaksi</p>
                <p class="font-semibold text-emerald-400">{{ $transaksi->nomor_transaksi }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400 mb-1">Tanggal & Waktu</p>
                <p class="font-semibold">{{ $transaksi->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400 mb-1">Kasir</p>
                <p class="font-semibold">{{ $transaksi->kasir->name }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400 mb-1">Status</p>
                @if ($transaksi->status === 'selesai')
                    <span class="badge-green">Selesai</span>
                @else
                    <span class="badge-red">Batal</span>
                @endif
            </div>
        </div>
    </div>

    <div class="card">
        <h3 class="font-bold text-sm mb-4 pb-3 border-b border-dark-400">Rincian Pembelian</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="table-th">Produk</th>
                        <th class="table-th text-center">Jumlah</th>
                        <th class="table-th text-right">Harga Satuan</th>
                        <th class="table-th text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi->detailTransaksi as $d)
                    <tr class="table-tr-hover">
                        <td class="table-td">
                            <p class="font-semibold text-sm">{{ $d->produk->nama_produk }}</p>
                            <p class="text-xs text-slate-500">{{ $d->produk->kode_produk }}</p>
                        </td>
                        <td class="table-td text-center">{{ $d->jumlah }}</td>
                        <td class="table-td text-right text-sm">Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                        <td class="table-td text-right font-semibold text-sm">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right py-3 pr-4 text-sm text-slate-400">Total Belanja</td>
                        <td class="text-right py-3 px-4 font-extrabold text-emerald-400 text-base border-t border-dark-400">
                            Rp {{ number_format($transaksi->total, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right py-2 pr-4 text-sm text-slate-400">Tunai (Bayar)</td>
                        <td class="text-right py-2 px-4 font-semibold text-sm">
                            Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right py-2 pr-4 text-sm text-slate-400">Kembalian</td>
                        <td class="text-right py-2 px-4 font-semibold text-sm">
                            Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
