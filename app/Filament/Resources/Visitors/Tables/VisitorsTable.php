<?php

namespace App\Filament\Resources\Visitors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VisitorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ip_address')
                    ->label('Alamat IP')
                    ->badge()
                    ->color('info')
                    ->searchable(),
                TextColumn::make('visited_url')
                    ->label('Halaman Dikunjungi')
                    ->searchable(),
                TextColumn::make('session_id')
                    ->label('ID Sesi')
                    ->limit(15)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Waktu Kunjungan')
                    ->dateTime('d M Y, H:i:s')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
