<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            [
                'name' => 'RS Sariningsih Bandung',
                'logo' => 'clients/r8ZjonTFS24C2dl6a0VBYy2emFNNpMou1sKB36iO.png',
                'asset_source' => 'Asset/Client-Logo/rs_sariningsih.png',
            ],
            [
                'name' => 'STPN Jogja',
                'logo' => 'clients/BSEkCwvUTH4HaOYOI0oembLuoPUAbtWz6YaArGRQ.jpg',
                'asset_source' => 'Asset/Client-Logo/stpn.jpeg',
            ],
            [
                'name' => 'Vokasi UNDIP',
                'logo' => 'clients/5UvyRYirgoY6E0d5D3npYLH5RJLfC2rlIAYk6h0g.jpg',
                'asset_source' => 'Asset/Client-Logo/vokasi_undip.jpeg',
            ],
        ];

        foreach ($clients as $item) {
            $sourcePath = public_path($item['asset_source']);
            if (File::exists($sourcePath)) {
                Storage::disk('public')->put($item['logo'], File::get($sourcePath));
            }

            Client::updateOrCreate(
                ['name' => $item['name']],
                [
                    'name' => $item['name'],
                    'logo' => $item['logo'],
                ]
            );
        }
    }
}

