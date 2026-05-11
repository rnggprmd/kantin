<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'kode_transaksi',
        'user_id',
        'pelanggan_nama',
        'total_harga',
        'metode_bayar',
        'uang_bayar',
        'kembalian',
        'status',
        'catatan',
        'snap_token',
        'payment_ref',
        'payment_status',
        'paid_at',
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
        'uang_bayar' => 'decimal:2',
        'kembalian' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public static function generateKode(): string
    {
        $prefix = 'TRX';
        $date = now()->format('Ymd');
        $last = static::whereDate('created_at', today())->count() + 1;
        return $prefix . $date . str_pad($last, 4, '0', STR_PAD_LEFT);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'selesai' => 'bg-emerald-100 text-emerald-700',
            'pending' => 'bg-amber-100 text-amber-700',
            'batal' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    public function restoreStock()
    {
        foreach ($this->details as $detail) {
            if ($detail->menu) {
                $detail->menu->increment('stok', $detail->qty);
            }
        }
    }
}
