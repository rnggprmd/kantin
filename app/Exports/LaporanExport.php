<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    public function __construct(
        protected string $tanggalDari,
        protected string $tanggalSampai
    ) {}

    public function collection()
    {
        return Transaksi::with(['user', 'details'])
            ->where('status', 'selesai')
            ->whereDate('created_at', '>=', $this->tanggalDari)
            ->whereDate('created_at', '<=', $this->tanggalSampai)
            ->orderByDesc('created_at')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Transaksi',
            'Tanggal',
            'Kasir',
            'Pelanggan',
            'Metode Bayar',
            'Total Harga',
            'Uang Bayar',
            'Kembalian',
            'Item',
        ];
    }

    public function map($transaksi): array
    {
        static $no = 0;
        $no++;

        $items = $transaksi->details->map(fn($d) => "{$d->nama_menu} x{$d->qty}")->join(', ');

        return [
            $no,
            $transaksi->kode_transaksi,
            $transaksi->created_at->format('d/m/Y H:i'),
            $transaksi->user?->name ?? '-',
            $transaksi->pelanggan_nama ?? '-',
            strtoupper($transaksi->metode_bayar),
            $transaksi->total_harga,
            $transaksi->uang_bayar ?? '-',
            $transaksi->kembalian ?? '-',
            $items,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return "Laporan {$this->tanggalDari} s/d {$this->tanggalSampai}";
    }
}
