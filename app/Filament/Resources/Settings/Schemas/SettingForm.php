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
                    ->label('Kunci')
                    ->required(),
                Textarea::make('value')
                    ->label('Nilai')
                    ->columnSpanFull(),
                TextInput::make('type')
                    ->required()
                    ->default('text'),
            ]);
    }
}
