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
                TextInput::make('slug')
                    ->label('Slug')
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
                            ->default(false),
                    ])
                    ->grid(2)
                    ->columnSpanFull()
                    ->defaultItems(0),
            ]);
    }
}
