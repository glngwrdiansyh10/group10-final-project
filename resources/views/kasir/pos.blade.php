@extends('layouts.app')
@section('title', 'Kasir — Jay-Mart')
@section('page-title', 'Point of Sale')
@section('page-subtitle', 'Cabang: ' . auth()->user()->cabang->nama_cabang)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- ── DAFTAR PRODUK ──────────────────────────────── --}}
    <div class="lg:col-span-2 card">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-dark-400">
            <h3 class="font-bold text-sm">Pilih Produk</h3>
            <div class="flex items-center bg-dark-800 border border-dark-500 rounded-lg px-3 gap-2">
                <i class="fas fa-search text-slate-500 text-xs"></i>
                <input id="searchProduk" type="text" placeholder="Cari produk..."
                    class="bg-transparent py-2 text-sm text-slate-200 placeholder-slate-500 outline-none w-40">
            </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 max-h-[480px] overflow-y-auto pr-1" id="produkGrid">
            @forelse ($produk as $p)
            @php $stokJumlah = $p->stok->first()?->jumlah ?? 0; @endphp
            <button type="button" onclick="addToCart({{ $p->id }}, '{{ $p->nama_produk }}', {{ $p->harga_jual }}, {{ $stokJumlah }})"
                class="p-3 bg-dark-800 border border-dark-500 rounded-xl text-left hover:border-emerald-500 hover:bg-emerald-500/5 transition-all duration-200 group produk-card"
                data-nama="{{ strtolower($p->nama_produk) }}">
                <div class="w-9 h-9 bg-emerald-500/15 rounded-lg flex items-center justify-center text-emerald-400 mb-2 group-hover:bg-emerald-500/25 transition-colors">
                    <i class="fas fa-box text-sm"></i>
                </div>
                <p class="text-xs font-semibold text-slate-200 leading-tight mb-1">{{ $p->nama_produk }}</p>
                <p class="text-xs text-emerald-400 font-bold">Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</p>
                <p class="text-[10px] text-slate-500 mt-0.5">Stok: {{ $stokJumlah }} {{ $p->satuan }}</p>
            </button>
            @empty
            <div class="col-span-3 py-10 text-center text-slate-500">
                <i class="fas fa-box-open text-3xl mb-2 block opacity-30"></i>
                <p class="text-sm">Tidak ada produk tersedia</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- ── KERANJANG ───────────────────────────────────── --}}
    <div class="card flex flex-col">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-dark-400">
            <h3 class="font-bold text-sm">Keranjang Belanja</h3>
            <button onclick="clearCart()" class="text-xs text-red-400 hover:text-red-300 transition-colors">
                <i class="fas fa-trash"></i> Hapus Semua
            </button>
        </div>

        <div class="flex-1 overflow-y-auto mb-4 relative min-h-[160px]">
            <div id="emptyCart" class="py-8 text-center text-slate-500 absolute inset-0 flex flex-col items-center justify-center">
                <i class="fas fa-shopping-cart text-3xl mb-2 block opacity-20"></i>
                <p class="text-xs">Keranjang kosong</p>
            </div>
            <div id="cartItemsList" class="space-y-2 relative z-10"></div>
        </div>

        <div class="border-t border-dark-400 pt-4 space-y-2">
            <div class="flex justify-between text-sm">
                <span class="text-slate-400">Subtotal</span>
                <span id="subtotalText" class="font-semibold">Rp 0</span>
            </div>
            <div class="flex justify-between text-base font-bold">
                <span class="text-emerald-400">Total</span>
                <span id="totalText" class="text-emerald-400">Rp 0</span>
            </div>
        </div>

        <form method="POST" action="{{ route('kasir.transaksi.store') }}" id="checkoutForm" class="mt-4 space-y-3">
            @csrf
            <div id="cartInputs"></div>
            <div>
                <label class="form-label text-xs">Jumlah Bayar (Rp)</label>
                <input id="bayarInput" name="bayar" type="number" min="0"
                    class="form-input text-lg font-bold" placeholder="0" oninput="hitungKembalian()">
            </div>
            <div class="flex justify-between text-sm bg-dark-800 px-3 py-2 rounded-lg">
                <span class="text-slate-400">Kembalian</span>
                <span id="kembalianText" class="font-bold text-emerald-400">Rp 0</span>
            </div>
            <button type="submit" id="checkoutBtn"
                class="btn-primary w-full justify-center py-3 text-base opacity-50 cursor-not-allowed"
                disabled>
                <i class="fas fa-check-circle"></i> Proses Transaksi
            </button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
let cart = {};
let total = 0;

function addToCart(id, nama, harga, stok) {
    if (cart[id]) {
        if (cart[id].jumlah >= stok) {
            alert('Stok ' + nama + ' tidak mencukupi!');
            return;
        }
        cart[id].jumlah++;
    } else {
        cart[id] = { nama, harga, jumlah: 1, stok };
    }
    renderCart();
}

function updateQty(id, delta) {
    if (!cart[id]) return;
    cart[id].jumlah += delta;
    if (cart[id].jumlah <= 0) {
        delete cart[id];
    } else if (cart[id].jumlah > cart[id].stok) {
        cart[id].jumlah = cart[id].stok;
        alert('Stok tidak mencukupi!');
    }
    renderCart();
}

function clearCart() { cart = {}; renderCart(); }

function renderCart() {
    const container = document.getElementById('cartItemsList');
    const empty     = document.getElementById('emptyCart');
    const inputs    = document.getElementById('cartInputs');
    const btn       = document.getElementById('checkoutBtn');
    total = 0;

    const items = Object.entries(cart);
    if (items.length === 0) {
        container.innerHTML = '';
        empty.style.display = 'flex';
        inputs.innerHTML = '';
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');
        document.getElementById('subtotalText').textContent = 'Rp 0';
        document.getElementById('totalText').textContent    = 'Rp 0';
        document.getElementById('kembalianText').textContent = 'Rp 0';
        return;
    }

    empty.style.display = 'none';
    let html = '', inputHtml = '';

    items.forEach(([id, item], i) => {
        const sub = item.harga * item.jumlah;
        total    += sub;
        html += `
        <div class="flex items-center justify-between gap-2 bg-dark-800 rounded-lg px-3 py-2">
            <div class="min-w-0 flex-1">
                <p class="text-xs font-semibold truncate">${item.nama}</p>
                <p class="text-[10px] text-emerald-400">Rp ${item.harga.toLocaleString('id-ID')} x ${item.jumlah}</p>
            </div>
            <div class="flex items-center gap-1.5 shrink-0">
                <button type="button" onclick="updateQty(${id}, -1)"
                    class="w-6 h-6 rounded bg-dark-600 text-slate-400 hover:bg-red-500/20 hover:text-red-400 text-xs transition-colors">-</button>
                <span class="text-xs font-bold w-4 text-center">${item.jumlah}</span>
                <button type="button" onclick="updateQty(${id}, 1)"
                    class="w-6 h-6 rounded bg-dark-600 text-slate-400 hover:bg-emerald-500/20 hover:text-emerald-400 text-xs transition-colors">+</button>
            </div>
        </div>`;
        inputHtml += `<input type="hidden" name="items[${i}][produk_id]" value="${id}">
                      <input type="hidden" name="items[${i}][jumlah]" value="${item.jumlah}">`;
    });

    container.innerHTML = html;
    inputs.innerHTML    = inputHtml;
    btn.disabled = false;
    btn.classList.remove('opacity-50', 'cursor-not-allowed');

    const fmt = v => 'Rp ' + v.toLocaleString('id-ID');
    document.getElementById('subtotalText').textContent = fmt(total);
    document.getElementById('totalText').textContent    = fmt(total);
    hitungKembalian();
}

function hitungKembalian() {
    const bayar = parseInt(document.getElementById('bayarInput').value) || 0;
    const kem   = bayar - total;
    const el    = document.getElementById('kembalianText');
    el.textContent = 'Rp ' + Math.max(0, kem).toLocaleString('id-ID');
    el.className   = kem >= 0 ? 'font-bold text-emerald-400' : 'font-bold text-red-400';
}

document.getElementById('searchProduk').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.produk-card').forEach(card => {
        card.style.display = card.dataset.nama.includes(q) ? 'block' : 'none';
    });
});
</script>
@endpush