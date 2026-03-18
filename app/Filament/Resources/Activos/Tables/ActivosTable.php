<?php

namespace App\Filament\Resources\Activos\Tables;

use App\Models\Activo;
//use Filament\Tables\Actions\EditAction;
//use Filament\Tables\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ActivosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('numero_inventario')
                    ->label('Número Inventario')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('material.nombre')
                    ->label('Material')
                    ->searchable(),

                TextColumn::make('material.marca')
                    ->label('Marca'),

                TextColumn::make('material.modelo')
                    ->label('Modelo'),

                TextColumn::make('numero_serie')
                    ->label('Número de Serie')
                    ->searchable(),

                TextColumn::make('costo')
                    ->label('Costo')
                    ->money('MXN'),

                TextColumn::make('garantia')
                    ->label('Garantía')
                    ->dateTime('d/m/Y'),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Disponible' => 'success',
                        'En uso' => 'info',
                        'Dañado' => 'danger',
                        'Fuera de servicio' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('empleadoActual.nombre')
                    ->label('Asignado a')
                    ->searchable(),

                TextColumn::make('detalles')
                    ->label('Detalles')
                    ->limit(50)
                    ->tooltip(fn(Activo $record) => $record->detalles),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                ImageColumn::make('imagenes')
                    ->label('Imágenes')
                    ->circular(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ]);
    }
}
