<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #ddd; }
        .header h1 { margin: 0 0 5px; font-size: 20px; color: #10b981; }
        .header p { margin: 0; color: #666; }
        .info { margin-bottom: 20px; }
        .info table { width: 100%; }
        .info td { padding: 3px; }
        table.data { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data th, table.data td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        table.data th { background-color: #f8f9fa; font-weight: bold; }
        .text-right { text-align: right !important; }
        .text-center { text-align: center !important; }
        .total-row { font-weight: bold; background-color: #f0fdf4; }
        .footer { margin-top: 30px; text-align: right; }
    </style>
</head>
<body>

    <div class="header">
        <h1>🏪 Jay-Mart</h1>
        <p>Laporan Penjualan — {{ $cabang->nama_cabang }}</p>
        <p>{{ $cabang->alamat }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="15%"><strong>Periode</strong></td>
                <td>: {{ \Carbon\Carbon::parse($dari)->format('d/m/Y') }} s.d {{ \Carbon\Carbon::parse($sampai)->format('d/m/Y') }}</td>
                <td width="15%" class="text-right"><strong>Dicetak Oleh</strong></td>
                <td width="20%">: {{ auth()->user()->name }}</td>
            </tr>
            <tr>
                <td><strong>Total Trx</strong></td>
                <td>: {{ $transaksi->count() }} transaksi</td>
                <td class="text-right"><strong>Tanggal Cetak</strong></td>
                <td>: {{ now()->format('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="18%">No. Transaksi</th>
                <th width="15%">Tanggal</th>
                <th width="20%">Kasir</th>
                <th width="10%" class="text-center">Item</th>
                <th width="15%" class="text-right">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksi as $i => $t)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $t->nomor_transaksi }}</td>
                <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $t->kasir->name }}</td>
                <td class="text-center">{{ $t->detailTransaksi->count() }}</td>
                <td class="text-right">{{ number_format($t->total, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada transaksi pada periode ini.</td>
            </tr>
            @endforelse
            @if ($transaksi->count() > 0)
            <tr class="total-row">
                <td colspan="5" class="text-right">TOTAL OMZET</td>
                <td class="text-right">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</td>
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
