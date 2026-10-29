<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'Desain Perancangan Rumah Sakit Sariningsih Bandung',
                'image_path' => 'sliders/qJ2K8a1S3dVOc736NHfinkF2eEPZSImVU6uQU7cb.jpg',
                'order' => 1,
                'is_active' => true,
                'asset_source' => 'Asset/Banner/banner1.jpeg',
            ],
            [
                'title' => 'Pembuatan IPAL STPDN Jogja',
                'image_path' => 'sliders/SchWAZ2m2ky9whxRoqoqxxxhDfqoagl1StRfchZp.jpg',
                'order' => 2,
                'is_active' => true,
                'asset_source' => 'Asset/Banner/Banner3.jpeg',
            ],
            [
                'title' => 'Perancangan Arsitektur RS Sariningsih Bandung',
                'image_path' => 'sliders/obVaSTQzvvVtEnhppl0292lmdTQApQvRrdCnZIlu.jpg',
                'order' => 3,
                'is_active' => true,
                'asset_source' => 'Asset/Banner/Banner2.jpeg',
            ],
        ];

        foreach ($sliders as $item) {
            $sourcePath = public_path($item['asset_source']);
            if (File::exists($sourcePath)) {
                Storage::disk('public')->put($item['image_path'], File::get($sourcePath));
            }

            Slider::updateOrCreate(
                ['order' => $item['order']],
                [
                    'title' => $item['title'],
                    'image_path' => $item['image_path'],
                    'order' => $item['order'],
                    'is_active' => $item['is_active'],
                ]
            );
        }
    }
}

