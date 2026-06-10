php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok — {{ $cabang->nama_cabang }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1e293b; background: #fff; padding: 30px; }
        .header { border-bottom: 2px solid #10b981; padding-bottom: 14px; margin-bottom: 18px; display: flex; justify-content: space-between; align-items: flex-end; }
        .header h1 { font-size: 18px; font-weight: 700; color: #10b981; }
        .header p { font-size: 11px; color: #64748b; margin-top: 2px; }
        .meta { font-size: 11px; text-align: right; color: #64748b; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        thead tr { background: #10b981; color: #fff; }
        thead th { padding: 7px 8px; text-align: left; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody td { padding: 6px 8px; border-bottom: 1px solid #e2e8f0; font-size: 10.5px; }
        .category-row td { background: #f1f5f9; font-weight: 700; font-size: 10px; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; padding: 5px 8px; }
        tfoot td { font-weight: 700; font-size: 11px; padding: 8px; border-top: 2px solid #10b981; }
        .badge { display: inline-block; padding: 2px 7px; border-radius: 99px; font-size: 9.5px; font-weight: 600; }
        .badge-green { background: #d1fae5; color: #065f46; }
        .badge-orange { background: #fef3c7; color: #92400e; }
        .badge-red { background: #fee2e2; color: #991b1b; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { margin-top: 24px; text-align: right; font-size: 10px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <h1>Laporan Stok Produk</h1>
            <p>Cabang: <strong>{{ $cabang->nama_cabang }}</strong></p>
            <p>Periode: {{ now()->translatedFormat('d F Y') }}</p>
        </div>
        <div class="meta">
            <p>JayMart POS System</p>
            <p>Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th class="text-center">Stok</th>
                <th>Satuan</th>
                <th class="text-right">Harga Beli</th>
                <th class="text-right">Nilai Stok</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @php $currentKategori = null; @endphp
            @foreach ($stok as $s)
            @if ($currentKategori !== $s->produk->kategori)
                @php $currentKategori = $s->produk->kategori; @endphp
                <tr class="category-row"><td colspan="8">{{ $currentKategori }}</td></tr>
            @endif
            <tr>
                <td>{{ $s->produk->kode_produk }}</td>
                <td>{{ $s->produk->nama_produk }}</td>
                <td>{{ $s->produk->kategori }}</td>
                <td class="text-center"><strong>{{ $s->jumlah }}</strong></td>
                <td>{{ $s->produk->satuan }}</td>
                <td class="text-right">Rp {{ number_format($s->produk->harga_beli, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($s->jumlah * $s->produk->harga_beli, 0, ',', '.') }}</td>
                <td class="text-center">
                    @if ($s->jumlah == 0)
                        <span class="badge badge-red">Habis</span>
                    @elseif ($s->jumlah <= $s->produk->stok_minimum)
                        <span class="badge badge-orange">Kritis</span>
                    @else
                        <span class="badge badge-green">Aman</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-right">Total Nilai Stok:</td>
                <td class="text-right">Rp {{ number_format($totalNilaiStok, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
    
    <div class="footer">
        Dicetak otomatis oleh Sistem JayMart
    </div>
</body>
</html>