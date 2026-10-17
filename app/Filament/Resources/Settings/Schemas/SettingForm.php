<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->label('Kunci Pengaturan (Key)')
                    ->required()
                    ->disabled(fn (?string $operation) => $operation === 'edit')
                    ->helperText(fn (?string $state) => match ($state) {
                        'whatsapp' => 'Nomor WhatsApp tujuan penerima chat pesan & hotline kontak (contoh: +62 812-8899-2026 atau 081288992026).',
                        'email' => 'Alamat email resmi perusahaan untuk penawaran & tender.',
                        'address' => 'Alamat lengkap kantor pusat dan workshop.',
                        'company_name' => 'Nama resmi perusahaan (tampil di navbar, footer, dan meta website).',
                        'tagline' => 'Visi atau deskripsi ringkas profil perusahaan di Hero Section.',
                        'founded_year' => 'Tahun pendirian perusahaan (EST).',
                        'years_experience' => 'Statistik Tahun Pengalaman (misal: 12+).',
                        'projects_done' => 'Statistik Proyek Selesai (misal: 250+).',
                        'engineers' => 'Statistik Tenaga Ahli (misal: 80+).',
                        default => 'Nama kunci konfigurasi unik.',
                    }),
                Textarea::make('value')
                    ->label('Nilai Konfigurasi (Value)')
                    ->rows(3)
                    ->columnSpanFull()
                    ->helperText('Isi nilai teks atau nomor yang akan ditampilkan di landing page website.'),
                TextInput::make('type')
                    ->label('Tipe Data')
                    ->required()
                    ->default('text')
                    ->disabled(),
            ]);
    }
}
