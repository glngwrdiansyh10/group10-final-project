@extends('layouts.app')
@section('title', 'Dashboard Manajer')
@section('page-title', 'Dashboard Manajer')
@section('page-subtitle', 'Cabang: ' . (auth()->user()->cabang->nama_cabang ?? '-'))
@section('content')
<div class="empty-state" style="padding:80px 20px">
    <i class="fas fa-gauge-high" style="color:var(--accent);opacity:1;font-size:56px"></i>
    <h3 style="font-size:20px;margin-top:16px">Dashboard Manajer</h3>
    <p style="margin-top:8px">Halaman ini akan dikerjakan oleh Ali (Laporan & Monitor Stok).</p>
</div>
@endsection
