<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'hotel_name', 'value' => 'Hotel Pro Cambodia'],
            ['key' => 'hotel_address', 'value' => 'ផ្លូវម៉ៅសេទុង, រាជធានីភ្នំពេញ'],
            ['key' => 'hotel_phone', 'value' => '023 123 456'],
            ['key' => 'hotel_email', 'value' => 'info@hotelpro.com'],
            ['key' => 'check_in_time', 'value' => '14:00'],
            ['key' => 'check_out_time', 'value' => '12:00'],
            ['key' => 'tax_rate', 'value' => '10'],
            ['key' => 'currency', 'value' => 'USD'],
            ['key' => 'timezone', 'value' => 'Asia/Phnom_Penh'],
            ['key' => 'maintenance_mode', 'value' => '0'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
