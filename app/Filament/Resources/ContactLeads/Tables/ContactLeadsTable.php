<?php

namespace App\Filament\Resources\ContactLeads\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ContactLeadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Pengirim')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('company')
                    ->label('Perusahaan / Instansi')
                    ->searchable()
                    ->placeholder('-'),
                TextColumn::make('service.title')
                    ->label('Jenis Layanan')
                    ->badge()
                    ->color('warning')
                    ->placeholder('Layanan Umum')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_followed_up')
                    ->label('Ditindak Lanjuti')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Diterima Pada')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('service_id')
                    ->label('Filter Jenis Layanan')
                    ->relationship('service', 'title'),
                TernaryFilter::make('is_followed_up')
                    ->label('Filter Status Tindak Lanjut'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
