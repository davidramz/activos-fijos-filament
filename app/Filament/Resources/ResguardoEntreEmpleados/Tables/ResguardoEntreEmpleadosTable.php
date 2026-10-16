<?php

namespace App\Filament\Resources\ResguardoEntreEmpleados\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\Resguardo;

class ResguardoEntreEmpleadosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->paginated([10, 25, 50, 100, 200])
            ->query(Resguardo::query()->where('tipo_id', 3))
            ->columns([
                TextColumn::make('folio_formateado')
                    ->label('Folio')
                    ->searchable(['folio', 'anio'])
                    ->sortable(),
                TextColumn::make('empleadoOrigen.nombre')
                    ->label('Empleado Origen')
                    ->searchable(['nombre', 'numero'])
                    ->sortable(),
                TextColumn::make('empleadoDestino.nombre')
                    ->label('Empleado Destino')
                    ->searchable(['nombre', 'numero'])
                    ->sortable(),
                // TextColumn::make('empleadoDestino.numero')
                //     ->label('No. Empleado')
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
                 //ViewAction::make(),
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
