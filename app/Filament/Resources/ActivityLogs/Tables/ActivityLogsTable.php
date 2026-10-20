<?php

namespace App\Filament\Resources\ActivityLogs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ActivityLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Pengguna')
                    ->default('System')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('action_type')
                    ->label('Aksi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        'login' => 'info',
                        'logout' => 'gray',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('model_type')
                    ->label('Modul')
                    ->formatStateUsing(fn ($state) => class_basename($state))
                    ->searchable(),
                TextColumn::make('model_id')
                    ->label('ID Target')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Keterangan')
                    ->limit(45)
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('action_type')
                    ->label('Aksi')
                    ->options([
                        'created' => 'Ditambah',
                        'updated' => 'Diperbarui',
                        'deleted' => 'Dihapus',
                        'login' => 'Login',
                        'logout' => 'Logout',
                    ]),
                SelectFilter::make('user_id')
                    ->label('Pengguna')
                    ->relationship('user', 'name'),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
