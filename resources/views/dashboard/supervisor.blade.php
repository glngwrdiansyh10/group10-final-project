@extends('layouts.app')
@section('title', 'Dashboard Supervisor')
@section('page-title', 'Dashboard Supervisor')
@section('page-subtitle', 'Cabang: ' . (auth()->user()->cabang->nama_cabang ?? '-'))
@section('content')
<div class="empty-state" style="padding:80px 20px">
    <i class="fas fa-eye" style="color:var(--accent);opacity:1;font-size:56px"></i>
    <h3 style="font-size:20px;margin-top:16px">Dashboard Supervisor</h3>
    <p style="margin-top:8px">Halaman ini akan dikerjakan oleh Ali (Monitor Transaksi & Stok).</p>
</div>
@endsection
