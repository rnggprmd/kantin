<?php

namespace Database\Seeders;

use App\Models\Inventaris;
use App\Models\Kategori;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // === USERS ===
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@kantinmaria.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@kantinmaria.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
            'phone' => '081234567891',
            'is_active' => true,
        ]);

        // === KATEGORI ===
        $makanan = Kategori::create(['nama' => 'Makanan', 'slug' => 'makanan', 'deskripsi' => 'Makanan berat dan ringan']);
        $minuman = Kategori::create(['nama' => 'Minuman', 'slug' => 'minuman', 'deskripsi' => 'Minuman dingin dan panas']);
        $snack   = Kategori::create(['nama' => 'Snack', 'slug' => 'snack', 'deskripsi' => 'Camilan dan gorengan']);

        // === MENU ===
        $menus = [
            // Makanan
            ['kategori_id' => $makanan->id, 'nama' => 'Nasi Goreng Spesial', 'harga' => 18000, 'stok' => 50, 'deskripsi' => 'Nasi goreng dengan telur, ayam, dan sayuran'],
            ['kategori_id' => $makanan->id, 'nama' => 'Nasi Ayam Geprek', 'harga' => 16000, 'stok' => 40, 'deskripsi' => 'Ayam geprek crispy dengan sambal merah'],
            ['kategori_id' => $makanan->id, 'nama' => 'Mie Goreng', 'harga' => 14000, 'stok' => 35, 'deskripsi' => 'Mie goreng dengan telur dan sayuran'],
            ['kategori_id' => $makanan->id, 'nama' => 'Nasi Kuning Komplit', 'harga' => 15000, 'stok' => 30, 'deskripsi' => 'Nasi kuning dengan lauk lengkap'],
            ['kategori_id' => $makanan->id, 'nama' => 'Bakso Kuah', 'harga' => 12000, 'stok' => 60, 'deskripsi' => 'Bakso sapi dengan kuah kaldu gurih'],
            // Minuman
            ['kategori_id' => $minuman->id, 'nama' => 'Es Teh Manis', 'harga' => 4000, 'stok' => 100, 'deskripsi' => 'Teh manis dingin segar'],
            ['kategori_id' => $minuman->id, 'nama' => 'Es Jeruk', 'harga' => 6000, 'stok' => 80, 'deskripsi' => 'Jeruk peras segar dengan es'],
            ['kategori_id' => $minuman->id, 'nama' => 'Air Mineral', 'harga' => 3000, 'stok' => 150, 'deskripsi' => 'Air mineral botol 600ml'],
            ['kategori_id' => $minuman->id, 'nama' => 'Kopi Susu', 'harga' => 8000, 'stok' => 50, 'deskripsi' => 'Kopi susu hangat atau dingin'],
            // Snack
            ['kategori_id' => $snack->id, 'nama' => 'Gorengan Mix', 'harga' => 5000, 'stok' => 80, 'deskripsi' => 'Tahu goreng, tempe, dan bakwan'],
            ['kategori_id' => $snack->id, 'nama' => 'Pisang Goreng', 'harga' => 5000, 'stok' => 60, 'deskripsi' => 'Pisang goreng crispy'],
        ];

        foreach ($menus as $data) {
            Menu::create(array_merge($data, ['is_tersedia' => true]));
        }

        // === INVENTARIS ===
        $inventaris = [
            ['nama' => 'Beras', 'satuan' => 'kg', 'stok' => 50, 'stok_minimum' => 10, 'harga_beli' => 12000, 'supplier' => 'Toko Sembako Jaya'],
            ['nama' => 'Minyak Goreng', 'satuan' => 'liter', 'stok' => 20, 'stok_minimum' => 5, 'harga_beli' => 14000, 'supplier' => 'Distributor Minyak'],
            ['nama' => 'Tepung Terigu', 'satuan' => 'kg', 'stok' => 15, 'stok_minimum' => 3, 'harga_beli' => 9000, 'supplier' => 'Toko Sembako Jaya'],
            ['nama' => 'Gula Pasir', 'satuan' => 'kg', 'stok' => 10, 'stok_minimum' => 2, 'harga_beli' => 13000, 'supplier' => 'Distributor Sembako'],
            ['nama' => 'Kopi Bubuk', 'satuan' => 'kg', 'stok' => 3, 'stok_minimum' => 1, 'harga_beli' => 75000, 'supplier' => 'Roastery Lokal'],
            ['nama' => 'Telur Ayam', 'satuan' => 'butir', 'stok' => 200, 'stok_minimum' => 50, 'harga_beli' => 2000, 'supplier' => 'Peternak Lokal'],
            ['nama' => 'Gas LPG 3kg', 'satuan' => 'tabung', 'stok' => 4, 'stok_minimum' => 2, 'harga_beli' => 25000, 'supplier' => '-'],
            ['nama' => 'Tahu Putih', 'satuan' => 'pcs', 'stok' => 8, 'stok_minimum' => 5, 'harga_beli' => 500, 'supplier' => 'Pengrajin Tahu'],
            ['nama' => 'Kecap Manis', 'satuan' => 'botol', 'stok' => 2, 'stok_minimum' => 2, 'harga_beli' => 15000, 'supplier' => 'Toko Sembako'],
            ['nama' => 'Air Galon', 'satuan' => 'galon', 'stok' => 6, 'stok_minimum' => 3, 'harga_beli' => 20000, 'supplier' => 'Depot Air'],
        ];

        foreach ($inventaris as $data) {
            Inventaris::create($data);
        }
    }
}
