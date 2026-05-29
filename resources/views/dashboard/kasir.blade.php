@extends('layouts.app')
@section('title', 'Dashboard Kasir')
@section('page-title', 'Kasir')
@section('page-subtitle', 'Cabang: ' . (auth()->user()->cabang->nama_cabang ?? '-'))
@section('content')
<div class="empty-state" style="padding:80px 20px">
    <i class="fas fa-cash-register" style="color:var(--accent);opacity:1;font-size:56px"></i>
    <h3 style="font-size:20px;margin-top:16px">Halaman Kasir</h3>
    <p style="margin-top:8px">Halaman ini akan dikerjakan oleh Nazwa (Input & Riwayat Transaksi).</p>
</div>
@endsection
