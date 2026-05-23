<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        User::create(['name' => 'Administrator',  'email' => 'admin@stockify.com',   'password' => Hash::make('admin123'),   'role' => 'admin',   'is_active' => true]);
        User::create(['name' => 'Budi Santoso',   'email' => 'manager@stockify.com', 'password' => Hash::make('manager123'), 'role' => 'manager', 'is_active' => true]);
        User::create(['name' => 'Siti Rahayu',    'email' => 'staff@stockify.com',   'password' => Hash::make('staff123'),   'role' => 'staff',   'is_active' => true]);

        // Categories
        $cats = Category::insert([
            ['name' => 'Elektronik', 'description' => 'Perangkat elektronik',   'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pakaian',    'description' => 'Pakaian dan aksesoris',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Makanan',    'description' => 'Produk makanan minuman', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Alat Tulis', 'description' => 'Peralatan tulis kantor', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Suppliers
        Supplier::create(['name' => 'PT Sumber Elektronik', 'phone' => '021-1234567', 'email' => 'info@sumber.com',    'address' => 'Jakarta',    'contact_person' => 'Hendra']);
        Supplier::create(['name' => 'CV Maju Bersama',      'phone' => '0274-987654', 'email' => 'order@maju.co.id',   'address' => 'Yogyakarta', 'contact_person' => 'Dewi']);
        Supplier::create(['name' => 'UD Berkah Jaya',       'phone' => '031-5678901', 'email' => 'sales@berkah.com',   'address' => 'Surabaya',   'contact_person' => 'Eko']);

        // Products
        $laptop = Product::create([
            'category_id' => 1,
            'supplier_id' => 1,
            'name' => 'Laptop ASUS VivoBook 14',
            'sku' => 'PRD-00001',
            'purchase_price' => 7500000,
            'selling_price' => 8999000,
            'stock' => 15,
            'minimum_stock' => 3,
            'unit' => 'unit',
            'description' => 'Laptop ringan Intel Core i5',
        ]);
        $laptop->attributes()->createMany([
            ['name' => 'Processor', 'value' => 'Intel Core i5-1135G7'],
            ['name' => 'RAM',       'value' => '8 GB DDR4'],
            ['name' => 'Storage',   'value' => '512 GB SSD'],
            ['name' => 'Warna',     'value' => 'Silver'],
        ]);

        Product::create([
            'category_id' => 1,
            'supplier_id' => 1,
            'name' => 'Mouse Wireless Logitech',
            'sku' => 'PRD-00002',
            'purchase_price' => 120000,
            'selling_price' => 175000,
            'stock' => 2,
            'minimum_stock' => 5,
            'unit' => 'unit',
        ]);

        Product::create([
            'category_id' => 2,
            'supplier_id' => 2,
            'name' => 'Kaos Polos Premium',
            'sku' => 'PRD-00003',
            'purchase_price' => 45000,
            'selling_price' => 89000,
            'stock' => 100,
            'minimum_stock' => 20,
            'unit' => 'pcs',
        ]);

        Product::create([
            'category_id' => 4,
            'supplier_id' => 2,
            'name' => 'Pulpen Pilot G2',
            'sku' => 'PRD-00004',
            'purchase_price' => 8000,
            'selling_price' => 14000,
            'stock' => 3,
            'minimum_stock' => 10,
            'unit' => 'pcs',
        ]);

        $this->command->info('✅ Seeder selesai!');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin',          'admin@stockify.com',   'admin123'],
                ['Manajer Gudang', 'manager@stockify.com', 'manager123'],
                ['Staff Gudang',   'staff@stockify.com',   'staff123'],
            ]
        );
    }
}
