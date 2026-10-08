<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
                Select::make('user_id')
                    ->label('Penulis')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->default(fn () => auth()->id())
                    ->required(),
                TextInput::make('title')
                    ->label('Judul')
                    ->required(),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required(),
                Textarea::make('content')
                    ->label('Konten')
                    ->columnSpanFull(),
                FileUpload::make('thumbnail')
                    ->label('Thumbnail')
                    ->image()
                    ->disk('public')
                    ->directory('posts'),
                TextInput::make('status')
                    ->label('Status')
                    ->required()
                    ->default('draft'),
                DateTimePicker::make('published_at')
                    ->label('Diterbitkan Pada'),
            ]);
    }
}
