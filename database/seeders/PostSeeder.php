<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = User::orderBy('id')->value('id');

        $posts = [
            [
                'category_slug' => 'pembangunan',
                'title' => 'Pengecoran Pondasi Gedung Bertingkat di Kawasan Sudirman',
                'slug' => 'pengecoran-pondasi-gedung-bertingkat-di-kawasan-sudirman',
                'content' => 'Proses pengecoran pondasi ini dilakukan dengan standar keamanan tinggi dan menggunakan beton kualitas K-400. Tim lapangan kami memastikan semua bekisting dan penulangan baja telah terpasang dengan sempurna sebelum penuangan dimulai. Pengawasan ketat diterapkan pada setiap titik elevasi.',
                'thumbnail' => 'posts/dummy_post_1.jpg',
                'status' => 'published',
                'published_at' => '2026-10-09 14:09:25',
                'asset_source' => 'Asset/Artikel/dummy_post_1.jpg',
            ],
            [
                'category_slug' => 'perancanaan',
                'title' => 'Inspeksi Keselamatan Kerja dan Evaluasi Struktur Baja',
                'slug' => 'inspeksi-keselamatan-kerja-dan-evaluasi-struktur-baja',
                'content' => 'Tinjauan rutin dilakukan oleh konsultan ahli dan manajer proyek di lokasi. Struktur baja diperiksa menggunakan metode Non-Destructive Testing (NDT) untuk menjamin kualitas las dan integritas kekuatan profil baja. Keamanan pekerja juga menjadi prioritas dengan penerapan protokol HSE (Health, Safety, Environment).',
                'thumbnail' => 'posts/dummy_post_2.jpg',
                'status' => 'published',
                'published_at' => '2026-10-07 14:09:25',
                'asset_source' => 'Asset/Artikel/dummy_post_2.jpg',
            ],
        ];

        foreach ($posts as $item) {
            $sourcePath = public_path($item['asset_source']);
            if (File::exists($sourcePath)) {
                Storage::disk('public')->put($item['thumbnail'], File::get($sourcePath));
            }

            $categoryId = Category::where('slug', $item['category_slug'])->value('id');

            Post::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'category_id' => $categoryId,
                    'user_id' => $userId,
                    'title' => $item['title'],
                    'slug' => $item['slug'],
                    'content' => $item['content'],
                    'thumbnail' => $item['thumbnail'],
                    'status' => $item['status'],
                    'published_at' => $item['published_at'],
                ]
            );
        }
    }
}

