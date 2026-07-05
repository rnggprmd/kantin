# 📖 Dokumentasi Sistem Kantin Maria

## 📋 Daftar Isi
- [Tentang Aplikasi](#tentang-aplikasi)
- [Fitur Utama](#fitur-utama)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Instalasi](#instalasi)
  - [Instalasi dengan Laragon](#instalasi-dengan-laragon)
  - [Instalasi dengan XAMPP](#instalasi-dengan-xampp)
  - [Instalasi dari GitHub](#instalasi-dari-github)
- [Konfigurasi](#konfigurasi)
- [Pengguna & Role](#pengguna--role)
- [Alur Aplikasi](#alur-aplikasi)
- [Modul & Fitur](#modul--fitur)
- [API Integrasi](#api-integrasi)
- [Troubleshooting](#troubleshooting)

---

## 🎯 Tentang Aplikasi

**Sistem Kantin Maria** adalah aplikasi Point of Sale (POS) berbasis web untuk mengelola transaksi kantin sekolah. Sistem ini mendukung:
- Pemesanan via QR Code untuk siswa
- Kasir untuk transaksi langsung
- Dashboard monitoring real-time
- Laporan penjualan
- Pembayaran tunai dan non-tunai (Midtrans)

---

## ✨ Fitur Utama

### 🔐 Multi-Role System
- **Admin**: Akses penuh (kelola menu, kategori, pengguna, laporan)
- **Kasir**: Kelola transaksi dan lihat menu
- **Siswa/Umum**: Pesan via QR Code tanpa login

### 📱 Pemesanan QR Code
- Scan QR Code meja untuk akses menu
- Pilih menu dan jumlah pesanan
- Pilih metode pembayaran (Tunai/Non-Tunai)
- Tracking status pesanan real-time
- Nomor antrean otomatis

### 💰 Transaksi
- Input transaksi manual oleh kasir
- Pembayaran tunai (dengan perhitungan kembalian)
- Pembayaran non-tunai via Midtrans (QRIS, VA, E-Wallet)
- Export nota PDF
- History transaksi dengan filter

### 🍕 Kitchen Display System (KDS)
- Dashboard pesanan masuk untuk staf dapur
- Update status pesanan: Menunggu → Diproses → Siap → Selesai
- Filter pesanan hari ini

### 📊 Dashboard & Laporan
- Statistik real-time (transaksi hari ini, pendapatan, dll)
- Grafik penjualan 7 hari terakhir
- Menu terlaris (30 hari)
- Distribusi metode pembayaran
- Performa kategori
- Export laporan Excel/PDF

### 🍔 Manajemen Menu & Kategori
- CRUD Menu (Nama, Harga, Kategori, Status Tersedia)
- CRUD Kategori
- Upload gambar menu
- Toggle ketersediaan menu

### 👥 Manajemen Pengguna (Admin)
- CRUD User (Admin/Kasir)
- Aktifkan/Nonaktifkan akun
- Ganti password

---

## 🛠️ Teknologi yang Digunakan

### Backend
- **Laravel 13** (PHP 8.3+)
- **SQLite** (default) / MySQL / PostgreSQL
- **Midtrans PHP SDK** - Payment gateway
- **DomPDF** - Generate PDF
- **Maatwebsite Excel** - Export Excel

### Frontend
- **Blade Templates**
- **TailwindCSS 4.0**
- **Vite** - Build tool
- **Alpine.js** (optional, bisa ditambahkan)

### Development Tools
- **Laravel Pail** - Log viewer
- **Laravel Pint** - Code formatter
- **Composer** - Dependency manager
- **NPM** - Frontend package manager

---

## 📦 Instalasi

### Requirement Sistem
- **PHP**: 8.3 atau lebih tinggi
- **Composer**: 2.x
- **Node.js**: 18.x atau lebih tinggi
- **NPM**: 9.x atau lebih tinggi
- **Database**: SQLite (default) / MySQL 8+ / PostgreSQL 14+
- **Web Server**: Apache / Nginx / Laragon / XAMPP

---

## 🚀 Instalasi dengan Laragon

### Langkah 1: Persiapan
1. Download dan install [Laragon](https://laragon.org/download/) (Full version recommended)
2. Pastikan PHP 8.3+ sudah terinstal di Laragon
3. Jalankan Laragon dan klik **Start All**

### Langkah 2: Clone/Download Project
```bash
# Via Git (di folder C:\laragon\www)
cd C:\laragon\www
git clone https://github.com/username/kantin.git
cd kantin

# Atau download ZIP dan extract ke C:\laragon\www\kantin
```

### Langkah 3: Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install frontend dependencies
npm install
```

### Langkah 4: Konfigurasi Environment
```bash
# Copy file .env
copy .env.example .env

# Generate application key
php artisan key:generate
```

### Langkah 5: Edit File .env
Buka file `.env` dan sesuaikan:
```env
APP_NAME="Kantin Maria"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://kantin.test

# Database (SQLite - default)
DB_CONNECTION=sqlite

# Midtrans (Optional - untuk pembayaran non-tunai)
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

### Langkah 6: Setup Database
```bash
# Membuat file database SQLite (jika belum ada)
type nul > database\database.sqlite

# Jalankan migrasi database
php artisan migrate

# Seed data awal (user, kategori, menu)
php artisan db:seed
```

### Langkah 7: Build Assets
```bash
# Build frontend assets
npm run build
```

### Langkah 8: Akses Aplikasi
1. Klik **Menu** di Laragon → **www** → **kantin**
2. Atau buka browser: `http://kantin.test`
3. Login dengan kredensial default:
   - **Admin**: `admin@kantinmaria.com` / `password`
   - **Kasir**: `kasir@kantinmaria.com` / `password`

---

## 🔧 Instalasi dengan XAMPP

### Langkah 1: Persiapan
1. Download dan install [XAMPP](https://www.apachefriends.org/download.html)
2. Pastikan **Apache** dan **MySQL** berjalan di XAMPP Control Panel
3. Pastikan PHP 8.3+ sudah ada (cek via `php -v` di CMD)
4. Install [Composer](https://getcomposer.org/download/) secara global
5. Install [Node.js](https://nodejs.org/) (LTS version)

### Langkah 2: Clone/Download Project
```bash
# Via Git (di folder C:\xampp\htdocs)
cd C:\xampp\htdocs
git clone https://github.com/username/kantin.git
cd kantin

# Atau download ZIP dan extract ke C:\xampp\htdocs\kantin
```

### Langkah 3: Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install frontend dependencies
npm install
```

### Langkah 4: Konfigurasi Environment
```bash
# Copy file .env
copy .env.example .env

# Generate application key
php artisan key:generate
```

### Langkah 5: Edit File .env
Buka file `.env` dan sesuaikan:

**Untuk SQLite (Recommended - Simple):**
```env
APP_NAME="Kantin Maria"
APP_URL=http://localhost/kantin/public

DB_CONNECTION=sqlite
```

**Untuk MySQL:**
```env
APP_NAME="Kantin Maria"
APP_URL=http://localhost/kantin/public

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kantin_db
DB_USERNAME=root
DB_PASSWORD=
```

### Langkah 6: Setup Database

**Jika pakai SQLite:**
```bash
# Membuat file database
type nul > database\database.sqlite
```

**Jika pakai MySQL:**
1. Buka phpMyAdmin: `http://localhost/phpmyadmin`
2. Buat database baru: `kantin_db`

**Kemudian jalankan migrasi:**
```bash
# Jalankan migrasi
php artisan migrate

# Seed data awal
php artisan db:seed
```

### Langkah 7: Build Assets
```bash
npm run build
```

### Langkah 8: Konfigurasi Virtual Host (Optional - Recommended)
Untuk URL yang lebih clean (`http://kantin.test` instead of `http://localhost/kantin/public`)

Edit file `C:\xampp\apache\conf\extra\httpd-vhosts.conf`:
```apache
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/kantin/public"
    ServerName kantin.test
    <Directory "C:/xampp/htdocs/kantin/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Edit file `C:\Windows\System32\drivers\etc\hosts` (Run as Administrator):
```
127.0.0.1 kantin.test
```

Restart Apache di XAMPP.

### Langkah 9: Akses Aplikasi
- Tanpa Virtual Host: `http://localhost/kantin/public`
- Dengan Virtual Host: `http://kantin.test`

Login:
- **Admin**: `admin@kantinmaria.com` / `password`
- **Kasir**: `kasir@kantinmaria.com` / `password`

---

## 🌐 Instalasi dari GitHub

### Clone Repository
```bash
# Clone project
git clone https://github.com/username/kantin.git
cd kantin

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database (SQLite)
touch database/database.sqlite  # Linux/Mac
type nul > database\database.sqlite  # Windows

# Migrate & seed
php artisan migrate --seed

# Build assets
npm run build

# Jalankan development server
php artisan serve
```

Akses: `http://localhost:8000`

---

## ⚙️ Konfigurasi

### Konfigurasi Midtrans (Pembayaran Non-Tunai)

1. Daftar di [Midtrans](https://midtrans.com/)
2. Dapatkan **Server Key** dan **Client Key** dari Dashboard
3. Tambahkan ke file `config/services.php`:

```php
'midtrans' => [
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),
    'is_3ds' => env('MIDTRANS_IS_3DS', true),
],
```

4. Tambahkan di `.env`:
```env
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxx
MIDTRANS_IS_PRODUCTION=false
```

5. Setup Webhook Midtrans:
   - URL: `https://yourdomain.com/midtrans/callback`
   - Method: POST

### Konfigurasi QR Code Meja

1. Login sebagai **Admin**
2. Buka menu **Meja**
3. Klik **Tambah Meja**
4. Masukkan:
   - Nomor Meja: `1`
   - Lokasi: `Depan Pintu Masuk`
   - Kode akan otomatis di-generate (contoh: `MEJA-ABC123`)
5. Klik **Simpan**
6. Download QR Code dengan klik tombol **QR Code**
7. Print dan tempel QR di meja

---

## 👥 Pengguna & Role

### Kredensial Default (Setelah Seeder)

| Role  | Email                      | Password   | Akses                                |
|-------|----------------------------|------------|--------------------------------------|
| Admin | admin@kantinmaria.com      | password   | Dashboard, Transaksi, Menu, Kategori, Pengguna, Laporan, Meja |
| Kasir | kasir@kantinmaria.com      | password   | Dashboard, Transaksi, Menu (Read Only), Kitchen Display |

### Hak Akses per Role

#### 👑 Admin
- ✅ Kelola Menu & Kategori
- ✅ Kelola Pengguna (CRUD)
- ✅ Kelola Meja & QR Code
- ✅ Lihat & Export Laporan
- ✅ Batalkan Transaksi
- ✅ Buat Transaksi
- ✅ Lihat Dashboard
- ✅ Kelola Kitchen Display

#### 💼 Kasir
- ✅ Buat Transaksi
- ✅ Lihat History Transaksi
- ✅ Export Nota PDF
- ✅ Lihat Dashboard
- ✅ Lihat Menu (Read Only)
- ✅ Update Status Pesanan (Kitchen Display)
- ❌ Kelola Pengguna
- ❌ Kelola Menu/Kategori
- ❌ Export Laporan
- ❌ Batalkan Transaksi

#### 🎓 Siswa/Umum (Tanpa Login)
- ✅ Scan QR Code
- ✅ Lihat Menu
- ✅ Buat Pesanan
- ✅ Pilih Metode Pembayaran
- ✅ Cek Status Pesanan
- ❌ Akses Dashboard
- ❌ Kelola Transaksi
- ❌ Akses fitur admin/kasir

---

## 🔄 Alur Aplikasi

### 📱 Alur Pemesanan Siswa (via QR Code)

```
1. Siswa scan QR Code di meja
   ↓
2. Terbuka halaman menu kantin
   ↓
3. Siswa pilih menu + jumlah
   ↓
4. Siswa isi nama pemesan
   ↓
5. Siswa pilih metode bayar:
   • Tunai → Bayar di kasir
   • Non-Tunai → Redirect ke Midtrans (QRIS/VA/E-Wallet)
   ↓
6. Pesanan masuk ke Kitchen Display System
   ↓
7. Staf dapur update status:
   [Menunggu] → [Diproses] → [Siap] → [Selesai]
   ↓
8. Siswa cek status via halaman tracking
   ↓
9. Pesanan selesai & transaksi tercatat
```

### 💰 Alur Transaksi Kasir (Manual Input)

```
1. Kasir login ke dashboard
   ↓
2. Klik menu "Transaksi" → "Buat Transaksi"
   ↓
3. Pilih menu dari daftar kategori
   ↓
4. Tentukan jumlah per menu
   ↓
5. Pilih metode bayar:
   • Tunai → Input jumlah uang bayar → Sistem hitung kembalian
   • Non-Tunai → Generate Snap Token Midtrans
   ↓
6. Simpan transaksi
   ↓
7. Cetak/Download nota PDF
   ↓
8. Transaksi tercatat di history
```

### 🍳 Alur Kitchen Display System

```
1. Pesanan masuk (dari QR Code/Kasir)
   ↓
2. Tampil di Kitchen Dashboard dengan status "Menunggu"
   ↓
3. Staf dapur klik "Proses" → Status: "Diproses"
   ↓
4. Setelah masak selesai, klik "Siap" → Status: "Siap"
   ↓
5. Setelah pesanan diambil, klik "Selesai" → Status: "Selesai"
   ↓
6. Pesanan hilang dari Kitchen Dashboard
```

### 📊 Alur Laporan (Admin)

```
1. Admin login ke dashboard
   ↓
2. Klik menu "Laporan"
   ↓
3. Filter berdasarkan:
   • Tanggal (dari - sampai)
   • Status transaksi
   • Metode pembayaran
   ↓
4. Klik "Lihat Laporan"
   ↓
5. Export:
   • PDF → Detail transaksi dalam format PDF
   • Excel → Data mentah untuk analisis
```

---

## 🧩 Modul & Fitur

### 1. Dashboard
**Route**: `/dashboard`  
**Akses**: Admin, Kasir

**Fitur:**
- Statistik hari ini (transaksi, pendapatan, pending)
- Total menu aktif
- Grafik penjualan 7 hari terakhir
- 10 transaksi terbaru
- Menu terlaris (30 hari)
- Distribusi metode pembayaran
- Performa kategori
- Kasir teraktif

**Teknologi**: Chart.js (optional), Laravel Eloquent

---

### 2. Kategori
**Route**: `/kategori`  
**Akses**: Admin

**Fitur:**
- ✅ Create, Read, Update, Delete
- ✅ Auto-generate slug
- ✅ Validasi unique slug

**File Controller**: `KategoriController.php`  
**Model**: `Kategori.php`  
**Views**: `resources/views/kategori/`

---

### 3. Menu
**Route**: `/menu`  
**Akses**: Admin (CRUD), Kasir (Read Only)

**Fitur:**
- ✅ CRUD Menu
- ✅ Upload gambar menu
- ✅ Toggle status tersedia/tidak tersedia
- ✅ Filter by kategori
- ✅ Search by nama

**File Controller**: `MenuController.php`  
**Model**: `Menu.php`  
**Views**: `resources/views/menu/`

---

### 4. Transaksi
**Route**: `/transaksi`  
**Akses**: Admin, Kasir

**Fitur:**
- ✅ Buat transaksi manual (kasir)
- ✅ History transaksi dengan pagination
- ✅ Filter by status, tanggal, kode transaksi
- ✅ Detail transaksi
- ✅ Export nota PDF
- ✅ Pembayaran tunai/non-tunai
- ✅ Perhitungan kembalian otomatis
- ✅ Batalkan transaksi (Admin only)

**Status Transaksi:**
- `pending`: Belum dibayar
- `selesai`: Sudah dibayar & selesai
- `batal`: Dibatalkan

**File Controller**: `TransaksiController.php`  
**Model**: `Transaksi.php`, `DetailTransaksi.php`  
**Views**: `resources/views/transaksi/`

---

### 5. Pemesanan (QR Code)
**Route**: `/order/{kode}`  
**Akses**: Public (tanpa login)

**Fitur:**
- ✅ Scan QR meja untuk akses
- ✅ Tampil daftar menu per kategori
- ✅ Pilih menu + qty
- ✅ Input nama pemesan
- ✅ Pilih metode bayar (tunai/non-tunai)
- ✅ Generate nomor antrean otomatis (reset per hari)
- ✅ Tracking status pesanan real-time
- ✅ Integrasi Midtrans untuk non-tunai

**Status Pesanan:**
- `menunggu`: Belum diproses
- `diproses`: Sedang dibuat
- `siap`: Siap diambil
- `selesai`: Sudah diambil

**File Controller**: `OrderController.php`  
**Model**: `Transaksi.php`, `Meja.php`  
**Views**: `resources/views/order/`

---

### 6. Kitchen Display System
**Route**: `/kitchen`  
**Akses**: Admin, Kasir

**Fitur:**
- ✅ Dashboard pesanan hari ini
- ✅ Filter status: Menunggu, Diproses
- ✅ Update status pesanan (AJAX)
- ✅ Nomor antrean & meja
- ✅ Detail item pesanan
- ✅ Timer pesanan (sejak dibuat)

**File Controller**: `OrderController.php`  
**Views**: `resources/views/order/kitchen.blade.php`

---

### 7. Laporan
**Route**: `/laporan`  
**Akses**: Admin

**Fitur:**
- ✅ Filter transaksi by tanggal & status
- ✅ Summary: Total transaksi, pendapatan, rata-rata
- ✅ Export PDF (summary + detail transaksi)
- ✅ Export Excel (raw data)

**File Controller**: `LaporanController.php`  
**Export Class**: `LaporanExport.php`  
**Views**: `resources/views/laporan/`

---

### 8. Meja (QR Code)
**Route**: `/meja`  
**Akses**: Admin

**Fitur:**
- ✅ CRUD Meja
- ✅ Auto-generate kode unik
- ✅ Generate QR Code (via API)
- ✅ Download QR Code
- ✅ Toggle aktif/nonaktif

**File Controller**: `MejaController.php`  
**Model**: `Meja.php`  
**QR Code**: Simple Data URL `https://yourdomain.com/order/{kode}`

---

### 9. Pengguna
**Route**: `/pengguna`  
**Akses**: Admin

**Fitur:**
- ✅ CRUD Pengguna (Admin/Kasir)
- ✅ Toggle aktif/nonaktif
- ✅ Ganti password (hash)
- ✅ Validasi unique email

**File Controller**: `PenggunaController.php`  
**Model**: `User.php`  
**Middleware**: `RoleMiddleware.php`

---

### 10. Profile (Self Service)
**Route**: `/profile`  
**Akses**: Admin, Kasir

**Fitur:**
- ✅ Lihat & edit profile sendiri
- ✅ Ganti password
- ✅ Update phone

**File Controller**: `ProfileController.php`  
**Views**: `resources/views/profile/`

---

## 🔗 API Integrasi

### Midtrans Payment Gateway

**Endpoint Callback**: `/midtrans/callback`  
**Method**: POST  
**Controller**: `MidtransController.php`

**Flow:**
1. User pilih metode non-tunai
2. Backend create Snap Token via Midtrans API
3. Frontend load Midtrans Snap popup
4. User bayar via QRIS/VA/E-Wallet
5. Midtrans kirim webhook ke `/midtrans/callback`
6. Backend update status transaksi

**Environment Variables:**
```env
MIDTRANS_SERVER_KEY=SB-Mid-server-xxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxx
MIDTRANS_IS_PRODUCTION=false
```

**Status Mapping:**
- `settlement` → Transaksi selesai
- `pending` → Menunggu pembayaran
- `deny` / `cancel` / `expire` → Transaksi batal

---

## 🐛 Troubleshooting

### Error: "Class 'Midtrans\Config' not found"
**Solusi:**
```bash
composer require midtrans/midtrans-php
```

### Error: "SQLSTATE[HY000]: General error: 1 no such table"
**Solusi:**
```bash
php artisan migrate:fresh --seed
```

### Error: "Failed to open the referenced table 'mejas'"
**Penyebab:** Urutan migration bermasalah (foreign key dibuat sebelum tabel reference-nya)

**Solusi:** Sudah diperbaiki di versi terbaru. Jika masih error:
```bash
# Reset database
php artisan migrate:fresh --seed
```

### Error: "npm ERR! code ENOENT"
**Solusi:**
```bash
npm cache clean --force
npm install
```

### Assets tidak muncul / Styling rusak
**Solusi:**
```bash
npm run build
php artisan optimize:clear
```

### Permission denied (Linux/Mac)
**Solusi:**
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Midtrans tidak jalan di localhost
**Solusi:**
1. Gunakan **ngrok** atau **expose.dev** untuk public URL
2. Update Midtrans webhook URL di dashboard Midtrans
3. Update `APP_URL` di `.env`

**Ngrok:**
```bash
ngrok http 80
# Salin URL https://xxx.ngrok.io
```

Update `.env`:
```env
APP_URL=https://xxx.ngrok.io
```

### QR Code tidak bisa diakses
**Solusi:**
1. Pastikan meja statusnya **Aktif**
2. Cek route public di `routes/web.php`
3. Pastikan tidak ada middleware `auth` di route `/order/{kode}`

---

## 📝 Catatan Pengembangan

### Development Mode
```bash
# Jalankan server development
php artisan serve

# Watch & compile assets
npm run dev

# Jalankan queue worker (untuk jobs)
php artisan queue:listen

# Lihat logs real-time
php artisan pail
```

### Production Deployment
```bash
# Optimize Laravel
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Build assets
npm run build

# Set environment
APP_ENV=production
APP_DEBUG=false
```

---

## 📞 Support & Kontribusi

Untuk bug report, feature request, atau kontribusi:
1. Buat **Issue** di GitHub repository
2. Fork repository & buat **Pull Request**
3. Hubungi developer via email

---

## 📄 Lisensi

MIT License - Free to use & modify

---

**Dibuat dengan ❤️ menggunakan Laravel 13**
