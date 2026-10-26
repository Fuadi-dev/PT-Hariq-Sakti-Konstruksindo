<?php

namespace App\Filament\Resources\Sliders\Schemas;

use App\Models\Slider;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SliderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul')
                    ->required(),
                FileUpload::make('image_path')
                    ->label('Gambar')
                    ->disk('public')
                    ->directory('sliders')
                    ->image()
                    ->required(),
                TextInput::make('order')
                    ->label('Urutan')
                    ->required()
                    ->numeric()
                    ->integer()
                    ->minValue(1)
                    ->rules(['min:1'])
                    ->default(fn () => ((int) Slider::max('order')) + 1)
                    ->unique(table: Slider::class, column: 'order', ignoreRecord: true)
                    ->validationMessages([
                        'min' => 'Nomor urut tidak boleh kurang dari atau sama dengan 0 (minimal 1).',
                        'unique' => 'Nomor urut ini sudah digunakan oleh slider lain. Silakan pilih nomor urut yang berbeda.',
                    ])
                    ->helperText(function ($record) {
                        $query = Slider::query();
                        if ($record && $record->getKey()) {
                            $query->whereKeyNot($record->getKey());
                        }
                        $usedOrders = $query->orderBy('order')->pluck('order')->all();
                        return !empty($usedOrders)
                            ? 'Nomor urut yang sudah terpakai: ' . implode(', ', $usedOrders) . '. Masukkan nomor urut unik minimal 1.'
                            : 'Nomor urut harus berupa angka unik minimal 1.';
                    }),
                Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->required(),
            ]);
    }
}
