<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Ir. Hendra Gunawan, S.T., M.M.',
                'position' => 'Head of Project Development - PT Nusantara Sarana Properti',
                'message' => 'PT Hariq Sakti Konstruksindo menunjukkan komitmen luar biasa dalam proyek pembangunan fasilitas komersial kami. Pengendalian jadwal pengerjaan sangat presisi, koordinasi lapangan berjalan mulus, dan standar K3 diterapkan tanpa kompromi. Hasil akhir melampaui ekspektasi kami.',
                'image' => null,
            ],
            [
                'name' => 'Bambang Wicaksono, M.T.',
                'position' => 'Project Manager - PT Mega Graha Mandiri',
                'message' => 'Kerja sama kami dalam pengerjaan struktur beton bertulang dan retaining wall berjalan sangat memuaskan. Tim engineer Hariq Sakti selalu transparan dalam laporan uji mutu dan pengawasan RAB, sehingga meminimalisir risiko deviasi anggaran.',
                'image' => null,
            ],
            [
                'name' => 'Dr. Ratna Indrayani',
                'position' => 'Direktur Operasional - Yayasan Pendidikan Bina Insani',
                'message' => 'Pembangunan gedung fasilitas akademik dan serbaguna terlaksana tepat waktu sebelum tahun ajaran baru. Komunikasi tim lapangan sangat responsif dan sigap memberikan solusi rekayasa terbaik saat menghadapi tantangan kontur tanah curam.',
                'image' => null,
            ],
            [
                'name' => 'Arif Setiawan, S.T.',
                'position' => 'VP Infrastructure & Facilities - PT Logistik Surya Express',
                'message' => 'Pengerjaan lantai industri heavy-duty dan struktur gudang logistik seluas 8.000 m² rampung lebih cepat dari target kontrak. Tingkat kerataan lantai (floor flatness) sangat presisi dan memenuhi standar operasional armada kami.',
                'image' => null,
            ],
            [
                'name' => 'Hj. Dewi Sartika, S.E.',
                'position' => 'Owner & Founder - Sentosa Business Park',
                'message' => 'Sangat puas dengan integritas dan profesionalisme tim PT Hariq Sakti Konstruksindo. Setiap tahapan pekerjaan didokumentasikan rapi dalam laporan progres mingguan. Konstruksi kokoh dan kualitas finishing sangat rapi.',
                'image' => null,
            ],
            [
                'name' => 'Farhan Ramadhan, M.Eng.',
                'position' => 'Chief Technical Officer - PT Graha Solusi Infrastruktur',
                'message' => 'Instalasi struktur bawah tanah dan sistem penampungan air terpadu dikerjakan sesuai spesifikasi teknis dan standar lingkungan hidup yang ketat. Rekanan kontraktor yang handal dan sangat direkomendasikan untuk proyek skala besar.',
                'image' => null,
            ],
        ];

        foreach ($testimonials as $item) {
            Testimonial::updateOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}
