<?php

namespace App\Filament\Resources\ContactLeads\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ContactLeadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('company'),
                Textarea::make('message')
                    ->columnSpanFull(),
                Toggle::make('is_followed_up')
                    ->required(),
            ]);
    }
}
