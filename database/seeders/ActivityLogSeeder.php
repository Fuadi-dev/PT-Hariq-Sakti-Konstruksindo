<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan data lama jika ingin re-seed bersih
        ActivityLog::truncate();

        // Hanya ada satu peran (admin), sehingga semua log atas nama admin pertama
        $superadmin = User::orderBy('id')->first();
        $admin = $superadmin;
        $writer = $superadmin;

        $logs = [
            [
                'user_id' => $superadmin?->id,
                'action_type' => 'updated',
                'model_type' => 'App\Models\Setting',
                'model_id' => 1,
                'description' => 'Memperbarui profil perusahaan, nomor WhatsApp hotline, dan email korespondensi',
                'created_at' => Carbon::now()->subDays(6)->addHours(2),
                'updated_at' => Carbon::now()->subDays(6)->addHours(2),
            ],
            [
                'user_id' => $admin?->id,
                'action_type' => 'created',
                'model_type' => 'App\Models\Project',
                'model_id' => 1,
                'description' => 'Menambahkan portofolio proyek: Pembangunan Univ A',
                'created_at' => Carbon::now()->subDays(5)->addHours(4),
                'updated_at' => Carbon::now()->subDays(5)->addHours(4),
            ],
            [
                'user_id' => $admin?->id,
                'action_type' => 'created',
                'model_type' => 'App\Models\Project',
                'model_id' => 2,
                'description' => 'Menambahkan portofolio proyek: Pekerjaan Struktur Dinding Penahan RS Sariningsih',
                'created_at' => Carbon::now()->subDays(4)->addHours(6),
                'updated_at' => Carbon::now()->subDays(4)->addHours(6),
            ],
            [
                'user_id' => $admin?->id,
                'action_type' => 'created',
                'model_type' => 'App\Models\Service',
                'model_id' => 2,
                'description' => 'Menambahkan layanan baru: Pembangunan dan Konstruksi Gedung',
                'created_at' => Carbon::now()->subDays(4)->addHours(8),
                'updated_at' => Carbon::now()->subDays(4)->addHours(8),
            ],
            [
                'user_id' => $writer?->id,
                'action_type' => 'created',
                'model_type' => 'App\Models\Post',
                'model_id' => 1,
                'description' => 'Menerbitkan artikel baru: Metode Pengecoran Mutu K-400 pada Proyek Gedung Bertingkat',
                'created_at' => Carbon::now()->subDays(3)->addHours(2),
                'updated_at' => Carbon::now()->subDays(3)->addHours(2),
            ],
            [
                'user_id' => $writer?->id,
                'action_type' => 'updated',
                'model_type' => 'App\Models\Post',
                'model_id' => 1,
                'description' => 'Memperbarui meta description dan cover thumbnail artikel pengecoran',
                'created_at' => Carbon::now()->subDays(3)->addHours(5),
                'updated_at' => Carbon::now()->subDays(3)->addHours(5),
            ],
            [
                'user_id' => $admin?->id,
                'action_type' => 'created',
                'model_type' => 'App\Models\Testimonial',
                'model_id' => 1,
                'description' => 'Menambahkan testimoni klien: Ir. Hendra Gunawan (PT Nusantara Sarana Properti)',
                'created_at' => Carbon::now()->subDays(2)->addHours(3),
                'updated_at' => Carbon::now()->subDays(2)->addHours(3),
            ],
            [
                'user_id' => $admin?->id,
                'action_type' => 'created',
                'model_type' => 'App\Models\Testimonial',
                'model_id' => 2,
                'description' => 'Menambahkan testimoni klien: Bambang Wicaksono, M.T. (PT Mega Graha Mandiri)',
                'created_at' => Carbon::now()->subDays(2)->addHours(7),
                'updated_at' => Carbon::now()->subDays(2)->addHours(7),
            ],
            [
                'user_id' => $writer?->id,
                'action_type' => 'created',
                'model_type' => 'App\Models\Post',
                'model_id' => 2,
                'description' => 'Menerbitkan catatan lapangan: Penerapan Standar K3 Konstruksi Menuju Zero Accident',
                'created_at' => Carbon::now()->subDays(1)->addHours(4),
                'updated_at' => Carbon::now()->subDays(1)->addHours(4),
            ],
            [
                'user_id' => $admin?->id,
                'action_type' => 'updated',
                'model_type' => 'App\Models\Project',
                'model_id' => 3,
                'description' => 'Memperbarui status pengerjaan proyek Ground Tank & Biofilter Terpadu menjadi 100% Selesai',
                'created_at' => Carbon::now()->subHours(8),
                'updated_at' => Carbon::now()->subHours(8),
            ],
            [
                'user_id' => $superadmin?->id,
                'action_type' => 'updated',
                'model_type' => 'App\Models\User',
                'model_id' => $writer?->id ?? 1,
                'description' => 'Memperbarui profil akun admin',
                'created_at' => Carbon::now()->subHours(3),
                'updated_at' => Carbon::now()->subHours(3),
            ],
            [
                'user_id' => $admin?->id,
                'action_type' => 'deleted',
                'model_type' => 'App\Models\Slider',
                'model_id' => 99,
                'description' => 'Menghapus slide banner pengumuman yang masa tayangnya telah berakhir',
                'created_at' => Carbon::now()->subHours(1),
                'updated_at' => Carbon::now()->subHours(1),
            ],
        ];

        foreach ($logs as $log) {
            ActivityLog::create($log);
        }
    }
}
