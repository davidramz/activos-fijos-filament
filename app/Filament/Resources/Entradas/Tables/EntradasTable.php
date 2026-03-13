<?php

namespace App\Filament\Resources\Entradas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EntradasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('folio')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('proveedor.nombre')
                    ->label('Proveedor')
                    ->searchable(),

                TextColumn::make('requisicion')
                    ->searchable(),

                TextColumn::make('tipo_compra')
                    ->label('Tipo de Compra'),

                TextColumn::make('fecha_factura')
                    ->label('Fecha de Factura')
                    ->dateTime('d/m/Y')
                    ->sortable(),

                TextColumn::make('activos_count')
                    ->label('Activos')
                    ->counts('activos'),

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
                //
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
