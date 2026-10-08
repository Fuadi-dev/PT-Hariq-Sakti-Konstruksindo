<?php

namespace App\Filament\Resources\ProjectImages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProjectImageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project_id')
                    ->label('Proyek')
                    ->relationship('project', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),
                FileUpload::make('image_path')
                    ->label('Gambar')
                    ->disk('public')
                    ->directory('projects')
                    ->image()
                    ->required(),
                Toggle::make('is_primary')
                    ->label('Utama')
                    ->required(),
            ]);
    }
}
