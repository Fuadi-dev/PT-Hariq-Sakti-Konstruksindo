<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'Desain dan Bangun (Design and Build)',
                'slug' => 'desain-dan-bangun-design-and-build',
                'description' => 'Layanan terintegrasi yang menggabungkan tahap perancangan (arsitektur dan rekayasa struktur) dengan pelaksanaan konstruksi fisik dalam satu kontrak tunggal.',
                'icon_or_image' => 'services/6ZOV8F6aEBasvNlEWsDSvqpCmEtAnwl5yOyoPXG4.jpg',
                'asset_source' => 'Asset/Layanan/Desain dan Bangun (Design and Build).jpg',
            ],
            [
                'title' => 'Mekanikal, Elektrikal, dan Plumbing (MEP)',
                'slug' => 'mekanikal-elektrikal-dan-plumbing-mep',
                'description' => 'Instalasi seluruh sistem utilitas bangunan. Ini mencakup jaringan panel dan instalasi listrik, sistem tata udara (HVAC), saluran air bersih dan kotor (plumbing), sistem proteksi kebakaran (hydrant/sprinkler), serta jaringan keamanan dan komunikasi.',
                'icon_or_image' => 'services/wYPBFkbY16eRRDzXuasYlQlh8lI0n97ZkaMaYuEr.jpg',
                'asset_source' => 'Asset/Layanan/Mekanikal, Elektrikal, dan Plumbing (MEP).jpg',
            ],
            [
                'title' => 'Pekerjaan Sipil dan Struktur',
                'slug' => 'pekerjaan-sipil-dan-struktur',
                'description' => 'Pembuatan struktur utama bangunan, termasuk penggalian dan pematangan lahan, pengerjaan pondasi, pengecoran beton, serta pemasangan rangka baja.',
                'icon_or_image' => 'services/ZlgJu6Wopmd4uQ3N2eeo47ER1FZNx99wjbzPcdRm.jpg',
                'asset_source' => 'Asset/Layanan/Pekerjaan Sipil dan Struktur.jpg',
            ],
            [
                'title' => 'Pekerjaan Arsitektur (Finishing)',
                'slug' => 'pekerjaan-arsitektur-finishing',
                'description' => 'Pekerjaan penyelesaian estetika dan fungsional bangunan, seperti pemasangan lantai, partisi dinding, plafon, pengecatan, pemasangan pintu/jendela, serta pengerjaan fasad eksterior.',
                'icon_or_image' => 'services/lZwPU33kKuWOhh74d2WiRd7HdgsFODOOmdyzXfXL.jpg',
                'asset_source' => 'Asset/Layanan/Pekerjaan Arsitektur (Finishing).jpg',
            ],
            [
                'title' => 'Manajemen Konstruksi',
                'slug' => 'manajemen-konstruksi',
                'description' => 'Pengelolaan proyek secara keseluruhan yang mencakup pengendalian anggaran biaya, penjadwalan waktu pelaksanaan, pengawasan kualitas kerja, administrasi proyek, keselamatan kerja (K3), serta manajemen sub-kontraktor dan vendor.',
                'icon_or_image' => 'services/yFchZLqCEwPdxq9BHCdK0LfH3CUZvTb62HrFjJdw.jpg',
                'asset_source' => 'Asset/Layanan/Manajemen Konstruksi.jpg',
            ],
            [
                'title' => 'Renovasi dan Fit-Out Interior',
                'slug' => 'renovasi-dan-fit-out-interior',
                'description' => 'Layanan perbaikan, perombakan struktur yang sudah ada, serta penyelesaian tata ruang dalam khusus untuk kebutuhan komersial, gedung perkantoran, pabrik, atau ritel.',
                'icon_or_image' => 'services/lV7CihIGv9IPiOuxgoGxG5Su4lICq8amgb2NKQWX.jpg',
                'asset_source' => 'Asset/Layanan/Renovasi dan Fit-Out Interior.jpg',
            ],
            [
                'title' => 'Pekerjaan Infrastruktur',
                'slug' => 'pekerjaan-infrastruktur',
                'description' => 'Pembangunan fasilitas pendukung kawasan atau fasilitas umum berskala besar seperti jalan raya, jalan akses proyek, area parkir, jembatan, dan sistem drainase lingkungan.',
                'icon_or_image' => 'services/XpqiNxg5iJdkxpMYu0M37pAmz9JjYMPJTVnujBWr.jpg',
                'asset_source' => 'Asset/Layanan/Pekerjaan Infrastruktur.jpg',
            ],
            [
                'title' => 'Estimasi Biaya dan Rekayasa Nilai (Value Engineering)',
                'slug' => 'estimasi-biaya-dan-rekayasa-nilai-value-engineering',
                'description' => 'Evaluasi dan perhitungan anggaran material serta metode kerja untuk memberikan solusi konstruksi yang paling efisien secara finansial tanpa mengorbankan kualitas, fungsi, atau standar keselamatan.',
                'icon_or_image' => 'services/SdDbkpqvAPHLQSIXyEewRMSC04deloUA25MkJC8x.jpg',
                'asset_source' => 'Asset/Layanan/Estimasi Biaya dan Rekayasa Nilai (Value Engineering).jpg',
            ],
        ];

        foreach ($services as $item) {
            $sourcePath = public_path($item['asset_source']);
            if (File::exists($sourcePath)) {
                Storage::disk('public')->put($item['icon_or_image'], File::get($sourcePath));
            }

            Service::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'title' => $item['title'],
                    'slug' => $item['slug'],
                    'description' => $item['description'],
                    'icon_or_image' => $item['icon_or_image'],
                ]
            );
        }
    }
}

