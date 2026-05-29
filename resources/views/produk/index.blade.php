@extends('layouts.app')
@section('title', 'Master Produk')
@section('page-title', 'Master Produk')
@section('page-subtitle', 'Kelola semua produk Jay-Mart')

@section('content')

{{-- Filter Bar --}}
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <form method="GET" class="flex flex-wrap gap-2 items-center">
        <div class="flex items-center bg-dark-700 border border-dark-500 rounded-lg px-3 gap-2">
            <i class="fas fa-search text-slate-500 text-xs"></i>
            <input name="search" type="text" placeholder="Cari nama / kode..."
                value="{{ request('search') }}"
                class="bg-transparent py-2 text-sm text-slate-200 placeholder-slate-500 outline-none w-44">
        </div>
        <select name="kategori" class="form-input w-auto py-2 text-sm">
            <option value="">Semua Kategori</option>
            @foreach ($kategori as $k)
                <option value="{{ $k }}" {{ request('kategori') === $k ? 'selected' : '' }}>{{ $k }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-secondary btn-sm"><i class="fas fa-filter"></i> Filter</button>
        @if(request()->anyFilled(['search','kategori']))
            <a href="{{ route('owner.produk.index') }}" class="btn-secondary btn-sm"><i class="fas fa-xmark"></i> Reset</a>
        @endif
    </form>
    <a href="{{ route('owner.produk.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Tambah Produk
    </a>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="table-th">Kode</th>
                    <th class="table-th">Nama Produk</th>
                    <th class="table-th">Kategori</th>
                    <th class="table-th">Satuan</th>
                    <th class="table-th">Harga Beli</th>
                    <th class="table-th">Harga Jual</th>
                    <th class="table-th">Stok Min</th>
                    <th class="table-th">Status</th>
                    <th class="table-th">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($produk as $p)
                <tr class="table-tr-hover">
                    <td class="table-td">
                        <code class="text-xs bg-dark-600 text-emerald-400 px-2 py-0.5 rounded">{{ $p->kode_produk }}</code>
                    </td>
                    <td class="table-td font-semibold text-sm">{{ $p->nama_produk }}</td>
                    <td class="table-td">
                        <span class="badge-blue">{{ $p->kategori }}</span>
                    </td>
                    <td class="table-td text-sm text-slate-400">{{ $p->satuan }}</td>
                    <td class="table-td text-sm">Rp {{ number_format($p->harga_beli, 0, ',', '.') }}</td>
                    <td class="table-td text-sm font-semibold text-emerald-400">Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</td>
                    <td class="table-td text-center text-sm">{{ $p->stok_minimum }}</td>
                    <td class="table-td">
                        @if ($p->is_active)
                            <span class="badge-green"><i class="fas fa-circle text-[7px]"></i> Aktif</span>
                        @else
                            <span class="badge-red"><i class="fas fa-circle text-[7px]"></i> Nonaktif</span>
                        @endif
                    </td>
                    <td class="table-td">
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('owner.produk.edit', $p) }}" class="btn-secondary btn-sm">
                                <i class="fas fa-pen-to-square"></i>
                            </a>
                            <form method="POST" action="{{ route('owner.produk.destroy', $p) }}"
                                  onsubmit="return confirm('Hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="py-16 text-center text-slate-500">
                        <i class="fas fa-box-open text-4xl mb-3 block opacity-20"></i>
                        <p class="font-semibold text-slate-400">Belum ada produk</p>
                        <a href="{{ route('owner.produk.create') }}" class="btn-primary mt-4 inline-flex">
                            <i class="fas fa-plus"></i> Tambah Produk Pertama
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($produk->hasPages())
    <div class="flex justify-center mt-5 pt-4 border-t border-dark-400">
        {{ $produk->links() }}
    </div>
    @endif
</div>

@endsection
