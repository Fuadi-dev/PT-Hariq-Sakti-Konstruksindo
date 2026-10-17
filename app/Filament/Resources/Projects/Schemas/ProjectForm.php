<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('client_id')
                    ->label('Klien')
                    ->relationship('client', 'name')
                    ->searchable()
                    ->preload(),
                TextInput::make('title')
                    ->label('Judul')
                    ->required(),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
                DatePicker::make('completion_date'),
                \Filament\Forms\Components\Repeater::make('images')
                    ->label('Daftar Gambar Proyek')
                    ->relationship('images')
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('image_path')
                            ->label('Gambar')
                            ->disk('public')
                            ->directory('projects')
                            ->image()
                            ->required(),
                        \Filament\Forms\Components\Toggle::make('is_primary')
                            ->label('Gambar Utama')
                            ->default(false)
                            ->live()
                            ->afterStateUpdated(function ($state, \Filament\Forms\Components\Toggle $component, \Livewire\Component $livewire) {
                                if ($state) {
                                    $statePath = $component->getStatePath();
                                    // Ambil path repeater (contoh: data.images atau images)
                                    preg_match('/^(.*images)\./', $statePath, $matches);
                                    if (!empty($matches[1])) {
                                        $repeaterPath = $matches[1];
                                        $items = data_get($livewire, $repeaterPath);
                                        if (is_array($items)) {
                                            foreach ($items as $uuid => $item) {
                                                $itemPath = "{$repeaterPath}.{$uuid}.is_primary";
                                                if ($itemPath !== $statePath) {
                                                    data_set($livewire, $itemPath, false);
                                                }
                                            }
                                        }
                                    }
                                }
                            }),
                    ])
                    ->grid(2)
                    ->columnSpanFull()
                    ->defaultItems(0),
            ]);
    }
}
