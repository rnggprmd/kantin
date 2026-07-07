<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Transaksi #{{ $transaksi->kode_transaksi }}</title>
    <style>
        @page { size: a4; margin: 0; }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            color: #1f2937; 
            line-height: 1.5;
            margin: 0;
            padding: 40px;
            background: #ffffff;
        }
        .header {
            border-bottom: 2px solid #15173D;
            padding-bottom: 20px;
            margin-bottom: 30px;
            display: table;
            width: 100%;
        }
        .header-left {
            display: table-cell;
            vertical-align: top;
        }
        .header-right {
            display: table-cell;
            vertical-align: top;
            text-align: right;
        }
        .brand {
            font-size: 24px;
            font-weight: 900;
            color: #15173D;
            text-transform: uppercase;
            letter-spacing: -1px;
            margin: 0;
        }
        .brand span { color: #982598; }
        .tagline {
            font-size: 10px;
            font-weight: bold;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-top: 4px;
        }
        .invoice-title {
            font-size: 28px;
            font-weight: 900;
            color: #111827;
            margin: 0;
            letter-spacing: -1px;
        }
        .invoice-date {
            font-size: 11px;
            color: #6b7280;
            margin-top: 5px;
            font-weight: bold;
        }
        
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 40px;
        }
        .info-col {
            display: table-cell;
            width: 33.33%;
            vertical-align: top;
        }
        .info-label {
            font-size: 9px;
            font-weight: 900;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 8px;
        }
        .info-value {
            font-size: 12px;
            font-weight: bold;
            color: #111827;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            background: #f9fafb;
            padding: 12px 15px;
            text-align: left;
            font-size: 10px;
            font-weight: 900;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid #e5e7eb;
        }
        td {
            padding: 15px;
            font-size: 11px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: top;
        }
        .item-name { font-weight: bold; color: #111827; font-size: 12px; }
        .item-meta { font-size: 9px; color: #9ca3af; margin-top: 3px; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .footer-grid {
            display: table;
            width: 100%;
            margin-top: 30px;
        }
        .footer-left {
            display: table-cell;
            width: 60%;
            vertical-align: bottom;
        }
        .footer-right {
            display: table-cell;
            width: 40%;
            vertical-align: top;
        }
        
        .total-box {
            background: #15173D;
            color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            text-align: right;
        }
        .total-label {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            opacity: 0.6;
            margin-bottom: 5px;
        }
        .total-amount {
            font-size: 24px;
            font-weight: 900;
        }
        
        .payment-info {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        .payment-row {
            display: table;
            width: 100%;
            font-size: 10px;
            margin-bottom: 4px;
        }
        .payment-label { display: table-cell; text-align: left; opacity: 0.5; }
        .payment-value { display: table-cell; text-align: right; font-weight: bold; }

        .stamp-container {
            margin-top: 40px;
            text-align: center;
        }
        .stamp {
            display: inline-block;
            border: 4px solid rgba(16, 185, 129, 0.2);
            color: rgba(16, 185, 129, 0.3);
            padding: 10px 30px;
            border-radius: 10px;
            font-size: 24px;
            font-weight: 900;
            text-transform: uppercase;
            transform: rotate(-10deg);
        }
        
        .disclaimer {
            margin-top: 60px;
            text-align: center;
            font-size: 9px;
            color: #9ca3af;
            border-top: 1px solid #f3f4f6;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <h1 class="brand">Kantin <span>Maria</span></h1>
            <p class="tagline">Premium Catering & Services</p>
        </div>
        <div class="header-right">
            <h2 class="invoice-title">OFFICIAL RECEIPT</h2>
            <p class="invoice-date">Ref: #{{ $transaksi->kode_transaksi }}</p>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-col">
            <div class="info-label">Tanggal Transaksi</div>
            <div class="info-value">{{ $transaksi->created_at->format('d/m/Y H:i') }}</div>
        </div>
        <div class="info-col">
            <div class="info-label">Tanggal Transaksi</div>
            <div class="info-value">{{ $transaksi->created_at->format('d F Y, H:i') }} WIB</div>
        </div>
        <div class="info-col">
            <div class="info-label">Metode Pembayaran</div>
            <div class="info-value" style="text-transform: uppercase;">{{ str_replace('_', ' ', $transaksi->metode_bayar) }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="50%">Deskripsi Menu</th>
                <th width="10%" class="text-center">Jumlah</th>
                <th width="20%" class="text-right">Harga Satuan</th>
                <th width="20%" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->details as $detail)
            <tr>
                <td>
                    <div class="item-name">{{ $detail->nama_menu }}</div>
                    <div class="item-meta">Category: {{ $detail->menu?->kategori?->nama ?? 'General' }}</div>
                </td>
                <td class="text-center">{{ $detail->qty }}</td>
                <td class="text-right">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                <td class="text-right" style="font-weight: bold;">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer-grid">
        <div class="footer-left">
            @if($transaksi->catatan && $transaksi->catatan !== '-')
            <div style="margin-bottom: 20px;">
                <div class="info-label">Catatan Tambahan</div>
                <div style="font-size: 10px; color: #6b7280; font-style: italic;">"{{ $transaksi->catatan }}"</div>
            </div>
            @endif
            
            <div class="stamp-container">
                @if($transaksi->status === 'selesai')
                    <div class="stamp">PAID & VERIFIED</div>
                @else
                    <div class="stamp" style="border-color: rgba(245, 158, 11, 0.2); color: rgba(245, 158, 11, 0.3);">PENDING</div>
                @endif
            </div>
        </div>
        <div class="footer-right">
            <div class="total-box">
                <div class="total-label">Grand Total</div>
                <div class="total-amount">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</div>
                
                @if($transaksi->metode_bayar === 'tunai')
                <div class="payment-info">
                    <div class="payment-row">
                        <div class="payment-label">Cash Received</div>
                        <div class="payment-value">Rp {{ number_format($transaksi->uang_bayar, 0, ',', '.') }}</div>
                    </div>
                    <div class="payment-row">
                        <div class="payment-label">Change Due</div>
                        <div class="payment-value">Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</div>
                    </div>
                </div>
                @endif
            </div>
            
            <div style="margin-top: 20px; text-align: right;">
                <div class="info-label">Otorisasi Kasir</div>
                <div class="info-value">{{ $transaksi->user?->name ?? 'System' }}</div>
            </div>
        </div>
    </div>

    <div class="disclaimer">
        Dokumen ini adalah bukti transaksi sah yang diterbitkan secara elektronik oleh Sistem Manajemen Kantin SMK PURNAMA 1 JAKARTA.<br>
        Terima kasih atas kunjungan Anda.
    </div>
</body>
</html>
