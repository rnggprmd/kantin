<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan — KANTIN SMK PURNAMA 1 JAKARTA</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 11px; color: #1e293b; margin: 0; padding: 20px; line-height: 1.5; }
        .header { text-align: center; border-bottom: 3px solid #15173D; padding-bottom: 20px; margin-bottom: 30px; position: relative; }
        .header h1 { margin: 0; font-size: 26px; color: #15173D; letter-spacing: 2px; font-weight: 900; }
        .header p { margin: 5px 0 0; color: #64748b; font-size: 12px; font-weight: bold; }
        .summary { display: table; width: 100%; border-spacing: 15px 0; margin-bottom: 30px; margin-left: -15px; margin-right: -15px; }
        .summary-box { display: table-cell; border: 1px solid #e2e8f0; background: #f8fafc; padding: 15px; border-radius: 12px; text-align: center; }
        .summary-box .label { font-size: 9px; color: #94a3b8; text-transform: uppercase; font-weight: 900; letter-spacing: 1px; margin-bottom: 5px; }
        .summary-box .value { font-size: 18px; font-weight: 900; color: #15173D; }
        
        .analytics-card { background: #fdf2ff; border: 1px solid #f5d0fe; border-radius: 12px; padding: 15px; }
        .analytics-title { margin: 0 0 12px 0; font-size: 10px; color: #982598; text-transform: uppercase; font-weight: 900; letter-spacing: 1px; border-bottom: 1px solid #f5d0fe; padding-bottom: 8px; }
        
        table { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 10px; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; }
        thead tr { background: #15173D; color: white; }
        thead th { padding: 12px 10px; text-align: left; font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; border: none; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody td { padding: 10px; border-bottom: 1px solid #f1f5f9; color: #334155; }
        .footer { margin-top: 40px; text-align: center; font-size: 9px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 20px; font-weight: bold; }
        .total-row { background: #15173D !important; color: white !important; font-weight: 900; }
        .total-row td { color: white !important; border: none; }
    </style>
</head>
<body>
    <div class="header">
        <h1>KANTIN SMK PURNAMA 1 JAKARTA</h1>
        <p>Laporan Penjualan — {{ \Carbon\Carbon::parse($tanggalDari)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($tanggalSampai)->format('d/m/Y') }}</p>
        <p>Dicetak: {{ now()->format('d/m/Y H:i') }} WIB</p>
    </div>

    <div class="summary">
        <div class="summary-box">
            <div class="label">Total Transaksi</div>
            <div class="value">{{ $totalTransaksi }} Nota</div>
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

    {{-- Analytics Section --}}
    <div style="margin-bottom: 25px;">
        <table style="border: none;">
            <tr>
                <td style="width: 48%; border: none; padding: 0; vertical-align: top;">
                    <div class="analytics-card">
                        <h3 class="analytics-title">Metode Pembayaran</h3>
                        @foreach($distribusiBayar as $d)
                        <div style="display: block; margin-bottom: 5px; font-size: 11px;">
                            <span style="text-transform: capitalize; float: left;">{{ str_replace('_', ' ', $d->metode_bayar) }}</span>
                            <span style="font-weight: bold; float: right;">{{ $d->jumlah }} Txn</span>
                            <div style="clear: both;"></div>
                        </div>
                        @endforeach
                    </div>
                </td>
                <td style="width: 4%; border: none;"></td>
                <td style="width: 48%; border: none; padding: 0; vertical-align: top;">
                    <div class="analytics-card">
                        <h3 class="analytics-title">5 Menu Terlaris</h3>
                        @foreach($menuTerlaris as $m)
                        <div style="display: block; margin-bottom: 5px; font-size: 11px;">
                            <span style="float: left;">{{ $m->nama_menu }}</span>
                            <span style="font-weight: bold; float: right;">{{ $m->total }} unit</span>
                            <div style="clear: both;"></div>
                        </div>
                        @endforeach
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <h3 style="font-size: 12px; color: #15173D; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px; font-weight: 900;">Rincian Transaksi</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Waktu</th>
                <th>Kasir</th>
                <th>Pelanggan</th>
                <th>Metode</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $i => $t)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td style="font-family: monospace; font-size: 9px; font-weight: bold;">{{ $t->kode_transaksi }}</td>
                <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $t->user?->name ?? '-' }}</td>
                <td style="text-transform: uppercase; font-size: 9px; font-weight: bold;">{{ $t->metode_bayar }}</td>
                <td style="font-weight: 900; color: #15173D; text-align: right;">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="6" style="text-align: right; font-weight: 900;">TOTAL PENDAPATAN:</td>
                <td style="text-align: right; font-weight: 900;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini dicetak secara otomatis oleh Sistem Manajemen Kantin SMK PURNAMA 1 JAKARTA
    </div>
</body>
</html>
