<?php

namespace App\Filament\Resources\Resguardos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ResguardosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('folioFormateado')
                    ->label('Folio')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('anio')
                    ->label('Año')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('empleado.nombre')
                    ->label('Empleado')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Creado por')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
