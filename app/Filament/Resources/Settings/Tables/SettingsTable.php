<?php

namespace App\Filament\Resources\Settings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Kunci Pengaturan')
                    ->badge()
                    ->color('warning')
                    ->description(fn (string $state): string => match ($state) {
                        'whatsapp' => 'Nomor WhatsApp Hotline & Tujuan Pesan',
                        'email' => 'Alamat Email Penawaran & Tender',
                        'address' => 'Alamat Kantor Pusat & Workshop',
                        'company_name' => 'Nama Resmi Perusahaan',
                        'tagline' => 'Tagline / Deskripsi Hero',
                        'founded_year' => 'Tahun Berdiri Perusahaan',
                        'years_experience' => 'Statistik Tahun Pengalaman',
                        'projects_done' => 'Statistik Proyek Selesai',
                        'engineers' => 'Statistik Tenaga Ahli',
                        default => 'Konfigurasi Sistem',
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('value')
                    ->label('Nilai Saat Ini')
                    ->limit(60)
                    ->searchable()
                    ->wrap(),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()->label('Ubah'),
            ])
            ->toolbarActions([]);
    }
}
