# 🗂️ Stockify — Aplikasi Manajemen Stok Barang

Aplikasi web manajemen stok gudang berbasis Laravel 10.

## Teknologi
- Laravel 10
- MySQL
- Tailwind CSS
- Flowbite

## Fitur
- Multi-role: Admin, Manajer Gudang, Staff Gudang
- Manajemen produk, kategori, supplier
- Transaksi barang masuk & keluar
- Stock opname
- Laporan stok & transaksi
- Aktivitas pengguna
- Pengaturan aplikasi (logo, nama, dll)

## Instalasi

1. Clone repository
   git clone https://github.com/username/stockify.git
   cd stockify

2. Install dependencies
   composer install

3. Copy file environment
   cp .env.example .env

4. Generate key
   php artisan key:generate

5. Setting database di .env
   DB_DATABASE=stockify
   DB_USERNAME=root
   DB_PASSWORD=

6. Jalankan migration & seeder
   php artisan migrate --seed

7. Buat symlink storage
   php artisan storage:link

8. Jalankan server
   php artisan serve

## Akun Default

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@stockify.com | admin123 |
| Manajer Gudang | manager@stockify.com | manager123 |
| Staff Gudang | staff@stockify.com | staff123 |