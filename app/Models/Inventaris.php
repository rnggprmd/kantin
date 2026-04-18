<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    protected $fillable = [
        'nama',
        'satuan',
        'stok',
        'stok_minimum',
        'harga_beli',
        'supplier',
        'keterangan',
    ];

    protected $casts = [
        'stok' => 'decimal:2',
        'stok_minimum' => 'decimal:2',
        'harga_beli' => 'decimal:2',
    ];

    public function isStokRendah(): bool
    {
        return $this->stok <= $this->stok_minimum;
    }
}
