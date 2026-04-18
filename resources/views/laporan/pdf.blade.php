<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan — Kantin Maria</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #1a1a1a; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #10b981; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 20px; color: #065f46; }
        .header p { margin: 4px 0 0; color: #6b7280; font-size: 11px; }
        .summary { display: flex; gap: 15px; margin-bottom: 20px; }
        .summary-box { flex: 1; border: 1px solid #d1fae5; background: #ecfdf5; padding: 12px; border-radius: 8px; }
        .summary-box .label { font-size: 10px; color: #6b7280; text-transform: uppercase; }
        .summary-box .value { font-size: 16px; font-weight: bold; color: #065f46; margin-top: 3px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        thead tr { background: #064e3b; color: white; }
        thead th { padding: 8px 10px; text-align: left; font-size: 11px; }
        tbody tr:nth-child(even) { background: #f9fafb; }
        tbody td { padding: 7px 10px; border-bottom: 1px solid #e5e7eb; }
        .footer { margin-top: 25px; text-align: center; font-size: 10px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 12px; }
        .total-row { background: #ecfdf5 !important; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>KANTIN MARIA</h1>
        <p>Laporan Penjualan — {{ \Carbon\Carbon::parse($tanggalDari)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($tanggalSampai)->format('d/m/Y') }}</p>
        <p>Dicetak: {{ now()->format('d/m/Y H:i') }} WIB</p>
    </div>

    <div class="summary">
        <div class="summary-box">
            <div class="label">Total Transaksi</div>
            <div class="value">{{ $totalTransaksi }}</div>
        </div>
        <div class="summary-box">
            <div class="label">Total Pendapatan</div>
            <div class="value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        </div>
        <div class="summary-box">
            <div class="label">Rata-rata Transaksi</div>
            <div class="value">Rp {{ $totalTransaksi > 0 ? number_format($totalPendapatan / $totalTransaksi, 0, ',', '.') : 0 }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Transaksi</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th>Pelanggan</th>
                <th>Metode Bayar</th>
                <th>Items</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $i => $t)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td style="font-family: monospace; font-size: 10px;">{{ $t->kode_transaksi }}</td>
                <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $t->user?->name ?? '-' }}</td>
                <td>{{ $t->pelanggan_nama ?? '-' }}</td>
                <td style="text-transform: uppercase; font-size: 10px;">{{ $t->metode_bayar }}</td>
                <td style="font-size: 10px; color: #6b7280;">
                    {{ $t->details->map(fn($d) => $d->nama_menu . ' x' . $d->qty)->join(', ') }}
                </td>
                <td style="font-weight: bold; color: #065f46;">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="7" style="text-align: right">TOTAL PENDAPATAN:</td>
                <td>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini dicetak secara otomatis oleh Sistem Manajemen Kantin Maria
    </div>
</body>
</html>
