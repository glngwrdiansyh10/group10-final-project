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

    <div class="sidebar-label">Laporan Cabang</div>
    <a href="{{ route('manajer.transaksi.laporan') }}"
       class="nav-item {{ request()->routeIs('manajer.transaksi.*') ? 'active' : '' }}">
        <i class="fas fa-file-invoice"></i> Laporan Transaksi
    </a>
    <a href="{{ route('manajer.stok.laporan') }}"
       class="nav-item {{ request()->routeIs('manajer.stok.*') ? 'active' : '' }}">
        <i class="fas fa-file-chart-pie"></i> Laporan Stok
    </a>
@endif

{{-- ── SUPERVISOR ───────────────────────────────────── --}}
@if ($role === 'supervisor')
    <div class="sidebar-label">Menu Utama</div>
    <a href="{{ route('supervisor.dashboard') }}"
       class="nav-item {{ request()->routeIs('supervisor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-gauge-high"></i> Dashboard
    </a>
@endif

{{-- ── KASIR ────────────────────────────────────────── --}}
@if ($role === 'kasir')
    <div class="sidebar-label">Transaksi</div>
    <a href="{{ route('kasir.dashboard') }}"
       class="nav-item {{ request()->routeIs('kasir.dashboard') ? 'active' : '' }}">
        <i class="fas fa-cash-register"></i> Kasir (POS)
    </a>
    <a href="{{ route('kasir.riwayat') }}"
       class="nav-item {{ request()->routeIs('kasir.riwayat') || request()->routeIs('kasir.struk') ? 'active' : '' }}">
        <i class="fas fa-clock-rotate-left"></i> Riwayat Transaksi
    </a>
@endif

{{-- ── GUDANG ───────────────────────────────────────── --}}
@if ($role === 'gudang')
    <div class="sidebar-label">Stok Barang</div>
    <a href="{{ route('gudang.dashboard') }}"
       class="nav-item {{ request()->routeIs('gudang.dashboard') ? 'active' : '' }}">
        <i class="fas fa-warehouse"></i> Informasi Stok
    </a>
    <a href="{{ route('gudang.mutasi.create') }}"
       class="nav-item {{ request()->routeIs('gudang.mutasi.create') ? 'active' : '' }}">
        <i class="fas fa-right-left"></i> Input Mutasi Stok
    </a>
    <a href="{{ route('gudang.mutasi.index') }}"
       class="nav-item {{ request()->routeIs('gudang.mutasi.index') ? 'active' : '' }}">
        <i class="fas fa-list-check"></i> Riwayat Mutasi
    </a>
@endif

