<?php

namespace Database\Seeders;

use App\Models\ContactLead;
use Illuminate\Database\Seeder;

class ContactLeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leads = [
            [
                'name' => 'Budi Santoso',
                'company' => 'PT Bangun Sejahtera',
                'service_id' => null,
                'message' => 'Halo saya ingin konsultasi',
                'is_followed_up' => true,
            ],
            [
                'name' => 'Mbut',
                'company' => 'Test',
                'service_id' => null,
                'message' => "[Jenis Layanan: manajemen proyek]\n\nmbut",
                'is_followed_up' => false,
            ],
        ];

        foreach ($leads as $item) {
            ContactLead::updateOrCreate(
                [
                    'name' => $item['name'],
                    'company' => $item['company'],
                ],
                $item
            );
        }
    }
}

