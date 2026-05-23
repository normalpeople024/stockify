<?php
// database/seeders/AppSettingSeeder.php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'app_name',        'value' => 'Stockify'],
            ['key' => 'app_description', 'value' => 'Sistem Manajemen Stok Gudang'],
            ['key' => 'app_logo',        'value' => null],
            ['key' => 'app_favicon',     'value' => null],
            ['key' => 'company_name',    'value' => 'PT. Nama Perusahaan'],
            ['key' => 'company_address', 'value' => ''],
            ['key' => 'company_phone',   'value' => ''],
            ['key' => 'company_email',   'value' => ''],
            ['key' => 'currency',        'value' => 'Rp'],
            ['key' => 'low_stock_alert', 'value' => '1'],
        ];

        foreach ($settings as $s) {
            AppSetting::updateOrCreate(['key' => $s['key']], ['value' => $s['value']]);
        }

        $this->command->info('✅ App settings seeded.');
    }
}
