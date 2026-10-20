<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Superadmin Hariq Sakti',
                'email' => 'admin@gmail.com',
                'role' => 'superadmin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Ahmad Fauzi (Admin Operasional)',
                'email' => 'admin.ops@hariqsakti.co.id',
                'role' => 'admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Siti Nurhaliza (Admin Proyek)',
                'email' => 'admin.proyek@hariqsakti.co.id',
                'role' => 'admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Rian Pratama (Content Writer)',
                'email' => 'writer@hariqsakti.co.id',
                'role' => 'writer',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Dinda Kirana (Media & Publikasi)',
                'email' => 'dinda.writer@hariqsakti.co.id',
                'role' => 'writer',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
