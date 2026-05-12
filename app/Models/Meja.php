<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    protected $fillable = ['nama', 'kode', 'is_aktif'];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
