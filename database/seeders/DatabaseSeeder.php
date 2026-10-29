<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ClientSeeder::class,
            SliderSeeder::class,
            ServiceSeeder::class,
            ProjectSeeder::class,
            TeamSeeder::class,
            PostSeeder::class,
            TestimonialSeeder::class,
            ContactLeadSeeder::class,
            VisitorSeeder::class,
            ActivityLogSeeder::class,
        ]);
    }
}
