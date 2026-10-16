<?php

namespace App\Filament\Resources\Activos\Tables;

use App\Filament\Exports\ActivoExporter;
use App\Filament\Exports\Enums\NetworkExportFormat;
use App\Models\Activo;
//use Filament\Tables\Actions\EditAction;
//use Filament\Tables\Actions\ViewAction;
use Filament\Actions\ExportAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;

class ActivosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->paginated([10, 25, 50, 100, 200])
            ->columns([
                TextColumn::make('numero_inventario')
                    ->label('Inventario')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status.nombre')
                ->label('Estado')
                ->badge()
                ->color(fn(string $state): string => match ($state) {
                    'ALMACEN' => 'almacen',
                    'RESGUARDADO' => 'success',
                    'BAJA' => 'baja',
                    'DEV.PROVEEDOR' => 'dev_proveedor',
                    'SUCEPTIBLE' => 'suceptible',
                    'CANCELADO' => 'danger',
                    'Reparacion' => 'warning',
                    default => 'gray',
                }),

                TextColumn::make('material.codigo')
                    ->label('Código')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('material.nombre')
                    ->label('Material')
                    ->limit(50)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('material.marca')
                    ->label('Marca'),

                TextColumn::make('material.modelo')
                    ->label('Modelo'),

                TextColumn::make('numero_serie')
                    ->label('Serie')
                    ->searchable(),

                // TextColumn::make('costo')
                //     ->label('Costo')
                //     ->money('MXN'),

                // TextColumn::make('garantia')
                //     ->label('Garantía')
                //     ->dateTime('d/m/Y'),

                

                // TextColumn::make('empleadoActual.nombre')
                //     ->label('Asignado a')
                //     ->searchable(),

                // TextColumn::make('detalles')
                //     ->label('Detalles')
                //     ->limit(50)
                //     ->tooltip(fn(Activo $record) => $record->detalles),

                // TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),

                // TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // IconColumn::make('imagenes_exists')
                //     ->label('Imagen')
                //     ->getStateUsing(fn ($record) => $record->imagenes[0] ?? null)
                //     ->icon(fn (bool $state) => $state
                //         ? 'heroicon-o-photo'
                //         : 'heroicon-o-x-circle'
                //     ),
                   
                // ImageColumn::make('imagenes')
                //     ->label('Imágenes')
                //     ->circular(),
            ])
            ->defaultSort('id', 'desc') // Sets default order
            ->filters([
                SelectFilter::make('status.nombre')
                    ->label('Estado')
                    ->relationship('status', 'nombre'),
            ])
            ->toolbarActions([
                ExportAction::make('exportar')
                    ->label('Exportar a Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->extraAttributes(['class' => 'export-excel-action'])
                    ->exporter(ActivoExporter::class)
                    ->formats([NetworkExportFormat::Xlsx])
                    ->columnMapping(false),
            ])
            ->recordActions([
                // ViewAction::make(),
                // EditAction::make(),
            ]);
    }
}
