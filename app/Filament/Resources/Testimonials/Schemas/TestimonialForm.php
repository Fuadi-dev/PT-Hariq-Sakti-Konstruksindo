<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama')
                    ->required(),
                TextInput::make('position')
                    ->label('Jabatan'),
                Textarea::make('message')
                    ->label('Pesan')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->label('Gambar')
                    ->disk('public')
                    ->directory('testimonials')
                    ->image(),
            ]);
    }
}
