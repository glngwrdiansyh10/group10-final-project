@php $role = auth()->user()->role; @endphp

{{-- ── OWNER ──────────────────────────────────────── --}}
@if ($role === 'owner')
    <div class="sidebar-label">Menu Utama</div>
    <a href="{{ route('owner.dashboard') }}"
       class="nav-item {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
        <i class="fas fa-chart-line"></i> Dashboard
    </a>

    <div class="sidebar-label">Manajemen</div>
    <a href="{{ route('owner.cabang.index') }}"
       class="nav-item {{ request()->routeIs('owner.cabang.*') ? 'active' : '' }}">
        <i class="fas fa-store"></i> Cabang
    </a>
    <a href="{{ route('owner.users.index') }}"
       class="nav-item {{ request()->routeIs('owner.users.*') ? 'active' : '' }}">
        <i class="fas fa-users"></i> Pegawai
    </a>
    <a href="{{ route('owner.produk.index') }}"
       class="nav-item {{ request()->routeIs('owner.produk.*') ? 'active' : '' }}">
        <i class="fas fa-box-open"></i> Master Produk
    </a>
@endif

{{-- ── MANAJER ─────────────────────────────────────── --}}
@if ($role === 'manajer')
    <div class="sidebar-label">Menu Utama</div>
    <a href="{{ route('manajer.dashboard') }}"
       class="nav-item {{ request()->routeIs('manajer.dashboard') ? 'active' : '' }}">
        <i class="fas fa-gauge-high"></i> Dashboard
    </a>

    <div class="sidebar-label">Transaksi</div>
    <a href="#" class="nav-item">
        <i class="fas fa-receipt"></i> Riwayat Transaksi
    </a>
    <a href="#" class="nav-item">
        <i class="fas fa-file-invoice"></i> Laporan Transaksi
    </a>

    <div class="sidebar-label">Stok</div>
    <a href="#" class="nav-item">
        <i class="fas fa-warehouse"></i> Stok Barang
    </a>
    <a href="#" class="nav-item">
        <i class="fas fa-file-chart-pie"></i> Laporan Stok
    </a>

    <div class="sidebar-label">SDM</div>
    <a href="#" class="nav-item">
        <i class="fas fa-users"></i> Pegawai Cabang
    </a>
@endif

{{-- ── SUPERVISOR ───────────────────────────────────────── --}}
@if ($role === 'supervisor')
    <div class="sidebar-label">Menu Utama</div>
    <a href="{{ route('supervisor.dashboard') }}"
       class="nav-item {{ request()->routeIs('supervisor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-gauge-high"></i> Dashboard
    </a>

    <div class="sidebar-label">Monitor</div>
    <a href="#" class="nav-item">
        <i class="fas fa-receipt"></i> Transaksi Hari Ini
    </a>
    <a href="#" class="nav-item">
        <i class="fas fa-warehouse"></i> Stok Barang
    </a>
@endif

{{-- ── KASIR ────────────────────────────────────────── --}}
@if ($role === 'kasir')
    <div class="sidebar-label">Transaksi</div>
    <a href="{{ route('kasir.dashboard') }}"
       class="nav-item {{ request()->routeIs('kasir.dashboard') ? 'active' : '' }}">
        <i class="fas fa-cash-register"></i> Kasir
    </a>
    <a href="#" class="nav-item">
        <i class="fas fa-clock-rotate-left"></i> Riwayat Transaksi
    </a>
@endif

{{-- ── GUDANG ───────────────────────────────────────── --}}
@if ($role === 'gudang')
    <div class="sidebar-label">Stok Barang</div>
    <a href="{{ route('gudang.dashboard') }}"
       class="nav-item {{ request()->routeIs('gudang.dashboard') ? 'active' : '' }}">
        <i class="fas fa-warehouse"></i> Dashboard Gudang
    </a>
    <a href="#" class="nav-item">
        <i class="fas fa-right-left"></i> Input Mutasi Stok
    </a>
    <a href="#" class="nav-item">
        <i class="fas fa-list-check"></i> Riwayat Mutasi
    </a>
@endif
