<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'whatsapp',
                'value' => '+62 812-8899-2026',
                'type' => 'text',
            ],
            [
                'key' => 'email',
                'value' => 'proyek@hariqsakti.co.id',
                'type' => 'text',
            ],
            [
                'key' => 'address',
                'value' => 'Gedung Konstruksindo Center, Jl. Jend. Sudirman Kav. 52–53, Jakarta Selatan',
                'type' => 'textarea',
            ],
            [
                'key' => 'company_name',
                'value' => 'PT. Hariq Sakti Konstruksindo',
                'type' => 'text',
            ],
            [
                'key' => 'tagline',
                'value' => 'Kontraktor sipil dan struktur yang menepati jadwal, menjaga anggaran, dan tidak berkompromi pada keselamatan kerja. Dari gudang industri hingga gedung bertingkat.',
                'type' => 'textarea',
            ],
            [
                'key' => 'founded_year',
                'value' => '2012',
                'type' => 'text',
            ],
        ];

        foreach ($settings as $item) {
            Setting::updateOrCreate(['key' => $item['key']], $item);
        }
    }
}
