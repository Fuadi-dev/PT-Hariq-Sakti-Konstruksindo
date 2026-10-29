<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            [
                'name' => 'Manajemen Project',
                'photo' => 'teams/IzUAb8p0tikO4HGQXK0yQKvjMCcnmh4ZojilLo5w.jpg',
                'asset_source' => 'Asset/Tim/Manajemen Project.jpg',
            ],
            [
                'name' => 'Staff Ahli',
                'photo' => 'teams/yuKyoZhb9aSxudTTU0PQN7cpHI0JBWjifcB7WYwu.jpg',
                'asset_source' => 'Asset/Tim/Staff Ahli.jpg',
            ],
        ];

        foreach ($teams as $item) {
            $sourcePath = public_path($item['asset_source']);
            if (File::exists($sourcePath)) {
                Storage::disk('public')->put($item['photo'], File::get($sourcePath));
            }

            Team::updateOrCreate(
                ['name' => $item['name']],
                [
                    'name' => $item['name'],
                    'photo' => $item['photo'],
                ]
            );
        }
    }
}

