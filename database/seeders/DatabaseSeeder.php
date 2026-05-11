<?php

namespace Database\Seeders;

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
            ['kategori_id' => $makanan->id, 'nama' => 'Nasi Goreng Spesial', 'harga' => 18000, 'deskripsi' => 'Nasi goreng dengan telur, ayam, dan sayuran'],
            ['kategori_id' => $makanan->id, 'nama' => 'Nasi Ayam Geprek', 'harga' => 16000, 'deskripsi' => 'Ayam geprek crispy dengan sambal merah'],
            ['kategori_id' => $makanan->id, 'nama' => 'Mie Goreng', 'harga' => 14000, 'deskripsi' => 'Mie goreng dengan telur dan sayuran'],
            ['kategori_id' => $makanan->id, 'nama' => 'Nasi Kuning Komplit', 'harga' => 15000, 'deskripsi' => 'Nasi kuning dengan lauk lengkap'],
            ['kategori_id' => $makanan->id, 'nama' => 'Bakso Kuah', 'harga' => 12000, 'deskripsi' => 'Bakso sapi dengan kuah kaldu gurih'],
            // Minuman
            ['kategori_id' => $minuman->id, 'nama' => 'Es Teh Manis', 'harga' => 4000, 'deskripsi' => 'Teh manis dingin segar'],
            ['kategori_id' => $minuman->id, 'nama' => 'Es Jeruk', 'harga' => 6000, 'deskripsi' => 'Jeruk peras segar dengan es'],
            ['kategori_id' => $minuman->id, 'nama' => 'Air Mineral', 'harga' => 3000, 'deskripsi' => 'Air mineral botol 600ml'],
            ['kategori_id' => $minuman->id, 'nama' => 'Kopi Susu', 'harga' => 8000, 'deskripsi' => 'Kopi susu hangat atau dingin'],
            // Snack
            ['kategori_id' => $snack->id, 'nama' => 'Gorengan Mix', 'harga' => 5000, 'deskripsi' => 'Tahu goreng, tempe, dan bakwan'],
            ['kategori_id' => $snack->id, 'nama' => 'Pisang Goreng', 'harga' => 5000, 'deskripsi' => 'Pisang goreng crispy'],
        ];

        foreach ($menus as $data) {
            Menu::create(array_merge($data, ['is_tersedia' => true]));
        }

    }
}
