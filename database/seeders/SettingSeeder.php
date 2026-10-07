<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'app_name', 'value' => 'Mali', 'type' => 'string'],
            ['key' => 'default_currency', 'value' => 'IRR', 'type' => 'string'],
            ['key' => 'currency_symbol', 'value' => 'ریال', 'type' => 'string'],
            ['key' => 'date_format', 'value' => 'Y/m/d', 'type' => 'string'],
            ['key' => 'pagination_per_page', 'value' => '15', 'type' => 'integer'],
            ['key' => 'upload_max_size', 'value' => '10240', 'type' => 'integer'],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
