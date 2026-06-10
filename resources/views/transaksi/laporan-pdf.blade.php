<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1e293b; background: #fff; }
        .header { text-align: center; border-bottom: 2px solid #10b981; padding-bottom: 12px; margin-bottom: 16px; }
        .header h1 { font-size: 20px; font-weight: 800; color: #10b981; }
        .header p { font-size: 11px; color: #64748b; margin-top: 2px; }
        .info-grid { display: flex; justify-content: space-between; margin-bottom: 16px; font-size: 10px; }
        .info-item { line-height: 1.6; }
        .info-label { color: #64748b; }
        .info-value { font-weight: 600; color: #0f172a; }
        .stats { display: flex; gap: 12px; margin-bottom: 16px; }
        .stat-box { flex: 1; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 12px; }
        .stat-box .label { font-size: 9px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
        .stat-box .value { font-size: 15px; font-weight: 800; color: #0f172a; margin-top: 2px; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #10b981; color: #fff; }
        thead th { padding: 7px 8px; text-align: left; font-size: 10px; font-weight: 600; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody td { padding: 6px 8px; font-size: 10px; border-bottom: 1px solid #e2e8f0; }
        .total-row { background: #ecfdf5 !important; font-weight: 700; }
        .footer { margin-top: 20px; text-align: center; font-size: 9px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Jay-Mart</h1>
        <p>{{ $cabang->nama_cabang }} &bull; {{ $cabang->alamat }}</p>
        <p style="margin-top: 4px; font-weight: 600; color: #0f172a;">LAPORAN TRANSAKSI</p>
    </div>

    <div class="info-grid">
        <div class="info-item">
            <p><span class="info-label">Periode: </span><span class="info-value">{{ \Carbon\Carbon::parse($dari)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($sampai)->format('d M Y') }}</span></p>
            <p><span class="info-label">Cabang: </span><span class="info-value">{{ $cabang->nama_cabang }}</span></p>
        </div>
        <div class="info-item" style="text-align: right;">
            <p><span class="info-label">Dicetak: </span><span class="info-value">{{ now()->format('d/m/Y H:i') }}</span></p>
        </div>
    </div>

    <div class="stats">
        <div class="stat-box">
            <p class="label">Total Transaksi</p>
            <p class="value">{{ $transaksi->count() }}</p>
        </div>
        <div class="stat-box">
            <p class="label">Total Omzet</p>
            <p class="value">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</p>
        </div>
        <div class="stat-box">
            <p class="label">Rata-rata/Transaksi</p>
            <p class="value">Rp {{ $transaksi->count() > 0 ? number_format($totalOmzet / $transaksi->count(), 0, ',', '.') : '0' }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>No. Transaksi</th>
                <th>Kasir</th>
                <th>Jml Item</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal & Waktu</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksi as $i => $t)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $t->nomor_transaksi }}</td>
                <td>{{ $t->kasir->name }}</td>
                <td style="text-align: center;">{{ $t->detailTransaksi->count() }}</td>
                <td style="font-weight: 600;">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                <td>{{ ucfirst($t->status) }}</td>
                <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 20px; color: #94a3b8;">Tidak ada transaksi</td>
            </tr>
            @endforelse
            <tr class="total-row">
                <td colspan="4" style="text-align: right;">TOTAL OMZET</td>
                <td>Rp {{ number_format($totalOmzet, 0, ',', '.') }}</td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh Sistem Jay-Mart &bull; {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>