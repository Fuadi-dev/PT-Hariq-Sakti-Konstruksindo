<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul')
                    ->required(),
                Textarea::make('content')
                    ->label('Konten')
                    ->columnSpanFull(),
                Textarea::make('meta_description')
                    ->columnSpanFull(),
            ]);
    }
}
