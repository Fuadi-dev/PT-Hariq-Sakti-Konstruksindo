<?php

namespace App\Filament\Resources\ContactLeads\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ContactLeadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama')
                    ->required(),
                TextInput::make('company')
                    ->label('Perusahaan / Instansi'),
                Select::make('service_id')
                    ->label('Jenis Layanan')
                    ->relationship('service', 'title')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                Textarea::make('message')
                    ->label('Pesan')
                    ->rows(4)
                    ->columnSpanFull(),
                Toggle::make('is_followed_up')
                    ->label('Sudah Ditindak Lanjuti')
                    ->required(),
            ]);
    }
}
