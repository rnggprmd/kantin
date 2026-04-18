<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kategori extends Model
{
    protected $fillable = ['nama', 'slug', 'deskripsi'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($kategori) {
            $kategori->slug = Str::slug($kategori->nama);
        });
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
