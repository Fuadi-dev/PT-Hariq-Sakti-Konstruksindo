<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Pembangunan',
                'slug' => 'pembangunan',
            ],
            [
                'name' => 'Perancanaan',
                'slug' => 'perancanaan',
            ],
        ];

        foreach ($categories as $item) {
            Category::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }
    }
}

