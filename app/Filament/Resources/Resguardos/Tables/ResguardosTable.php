<?php

namespace App\Filament\Resources\Resguardos\Tables;

use App\Models\Resguardo;
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
            ->query(Resguardo::query()->where('tipo_id', 1))
            ->columns([
                TextColumn::make('folio_formateado')
                    ->label('Folio')
                    ->searchable(['folio', 'anio'])
                    ->sortable(),
                TextColumn::make('empleadoOrigen.nombre')
                    ->label('Empleado')
                    ->searchable(['nombre', 'numero'])
                    ->sortable(),
                // TextColumn::make('empleado.numero')
                //     ->label('Número')
                //     ->sortable(),
                // TextColumn::make('tipo.nombre')
                //     ->label('Tipo')
                //     ->searchable()
                //     ->sortable(),
                // TextColumn::make('activos_count')
                //     ->label('Cantidad de Activos')
                //     ->counts('activos')
                //     ->sortable(),
                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Creado por')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
