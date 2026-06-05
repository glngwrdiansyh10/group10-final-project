<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #ddd; }
        .header h1 { margin: 0 0 5px; font-size: 20px; color: #3b82f6; }
        .header p { margin: 0; color: #666; }
        .info { margin-bottom: 20px; }
        .info table { width: 100%; }
        .info td { padding: 3px; }
        table.data { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data th, table.data td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        table.data th { background-color: #f8f9fa; font-weight: bold; }
        .text-right { text-align: right !important; }
        .text-center { text-align: center !important; }
        .total-row { font-weight: bold; background-color: #eff6ff; }
        .text-danger { color: #ef4444; }
        .footer { margin-top: 30px; text-align: right; }
    </style>
</head>
<body>

    <div class="header">
        <h1>🏪 Jay-Mart</h1>
        <p>Laporan Posisi Stok Barang — {{ $cabang->nama_cabang }}</p>
        <p>{{ $cabang->alamat }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="15%"><strong>Dicetak Oleh</strong></td>
                <td>: {{ auth()->user()->name }} (Manajer)</td>
                <td width="20%" class="text-right"><strong>Tanggal Cetak</strong></td>
                <td width="20%">: {{ now()->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td><strong>Total Item</strong></td>
                <td>: {{ $stok->count() }} jenis produk</td>
                <td colspan="2"></td>
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="15%">Kode</th>
                <th width="30%">Nama Produk</th>
                <th width="15%">Kategori</th>
                <th width="10%" class="text-center">Stok Min</th>
                <th width="10%" class="text-center">Tersedia</th>
                <th width="15%" class="text-right">Nilai Aset (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($stok as $i => $s)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $s->produk->kode_produk }}</td>
                <td>{{ $s->produk->nama_produk }}</td>
                <td>{{ $s->produk->kategori }}</td>
                <td class="text-center">{{ $s->produk->stok_minimum }}</td>
                <td class="text-center {{ $s->jumlah <= $s->produk->stok_minimum ? 'text-danger' : '' }}">
                    <strong>{{ $s->jumlah }}</strong> {{ $s->produk->satuan }}
                </td>
                <td class="text-right">{{ number_format($s->jumlah * $s->produk->harga_beli, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Belum ada data stok.</td>
            </tr>
            @endforelse
            @if ($stok->count() > 0)
            <tr class="total-row">
                <td colspan="6" class="text-right">TOTAL NILAI ASET (HARGA BELI)</td>
                <td class="text-right">Rp {{ number_format($totalNilaiStok, 0, ',', '.') }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        <p>Mengetahui,</p>
        <br><br><br>
        <p><strong>{{ auth()->user()->name }}</strong></p>
        <p>Manajer Toko</p>
    </div>

</body>
</html>
