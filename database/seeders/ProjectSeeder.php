<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'client_name' => 'RS Sariningsih Bandung',
                'title' => 'Pembangunan Univ A',
                'slug' => 'pembangunan-univ-a',
                'description' => 'pembagunan konstruksi perancangan pada universitas',
                'completion_date' => null,
                'images' => [
                    [
                        'image_path' => 'projects/YhrBLnLpGqDWIqZqPWoNokxQpfDUBOB0YbQb19VL.jpg',
                        'is_primary' => true,
                        'asset_source' => 'Asset/Proyek/Pembangunan Univ A.jpg',
                    ],
                ],
            ],
            [
                'client_name' => 'STPN Jogja',
                'title' => 'Pekerjaan Struktur Dinding Penahan RS Sariningsih',
                'slug' => 'pekerjaan-struktur-dinding-penahan-rs-sariningsih',
                'description' => 'Pekerjaan bekisting, penulangan beton bertulang, dan dinding penahan tanah berpresisi tinggi dengan standar K3 ketat.',
                'completion_date' => '2024-10-15',
                'images' => [
                    [
                        'image_path' => 'projects/u4JiPRSFD2DuPdR6r018UdAxd6ieRdHx8MUSb1eG.jpg',
                        'is_primary' => true,
                        'asset_source' => 'Asset/Proyek/Pekerjaan Struktur Dinding Penahan RS Sariningsih.jpg',
                    ],
                ],
            ],
            [
                'client_name' => 'Vokasi UNDIP',
                'title' => 'Instalasi Ground Tank & Biofilter Terpadu',
                'slug' => 'instalasi-ground-tank-biofilter-terpadu',
                'description' => 'Penggalian lahan, penempatan tangki biofilter bawah tanah, serta instalasi sistem perpipaan dan utilitas ramah lingkungan.',
                'completion_date' => '2025-02-20',
                'images' => [
                    [
                        'image_path' => 'projects/1YBjfCwxbDoJHD9VY5Hs3Hb69ARFxtEjuLDEiPmm.jpg',
                        'is_primary' => true,
                        'asset_source' => 'Asset/Proyek/Instalasi Ground Tank & Biofilter Terpadu.jpg',
                    ],
                ],
            ],
        ];

        foreach ($projects as $item) {
            $clientId = Client::where('name', $item['client_name'])->value('id');

            $project = Project::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'client_id' => $clientId,
                    'title' => $item['title'],
                    'slug' => $item['slug'],
                    'description' => $item['description'],
                    'completion_date' => $item['completion_date'],
                ]
            );

            foreach ($item['images'] as $img) {
                $sourcePath = public_path($img['asset_source']);
                if (File::exists($sourcePath)) {
                    Storage::disk('public')->put($img['image_path'], File::get($sourcePath));
                }

                ProjectImage::updateOrCreate(
                    [
                        'project_id' => $project->id,
                        'image_path' => $img['image_path'],
                    ],
                    [
                        'is_primary' => $img['is_primary'],
                    ]
                );
            }
        }
    }
}

