<?php

namespace Database\Seeders;

use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VisitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan data lama jika ingin re-seed bersih
        Visitor::truncate();

        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36',
            'Mozilla/5.0 (Linux; Android 14; SM-S918B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Mobile Safari/537.36',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 17_6_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.4 Safari/605.1.15',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36 Edg/129.0.2792.79',
        ];

        $ips = [
            '182.253.140.22',
            '114.124.208.55',
            '36.85.12.98',
            '103.28.148.12',
            '180.252.88.19',
            '140.213.33.64',
            '110.137.91.43',
            '103.111.201.78',
        ];

        $urls = [
            '/',
            '/',
            '/tentang-kami',
            '/layanan',
            '/layanan/pembangunan-dan-konstruksi',
            '/layanan/manajemen-proyek',
            '/proyek',
            '/proyek/pembangunan-univ-a',
            '/artikel',
            '/kontak',
        ];

        $visitors = [];
        $baseDate = Carbon::now()->subDays(10);

        // Buat 35 log pengunjung acak dalam 10 hari terakhir
        for ($i = 0; $i < 35; $i++) {
            $sessionId = Str::random(40);
            $ip = $ips[array_rand($ips)];
            $ua = $userAgents[array_rand($userAgents)];
            $visitedUrl = $urls[array_rand($urls)];

            // Acak waktu kunjungan bertahap
            $visitTime = (clone $baseDate)->addHours(rand(1, 240))->addMinutes(rand(0, 59));

            if ($visitTime->isFuture()) {
                $visitTime = Carbon::now()->subMinutes(rand(5, 180));
            }

            $visitors[] = [
                'ip_address' => $ip,
                'user_agent' => $ua,
                'session_id' => $sessionId,
                'visited_url' => $visitedUrl,
                'created_at' => $visitTime,
                'updated_at' => $visitTime,
            ];
        }

        // Urutkan berdasarkan waktu created_at
        usort($visitors, fn ($a, $b) => $a['created_at'] <=> $b['created_at']);

        foreach ($visitors as $v) {
            Visitor::create($v);
        }
    }
}
