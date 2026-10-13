<?php

namespace App\Filament\Resources\Entradas\Tables;

use App\Filament\Exports\EntradaExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EntradasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('consecutivo')
                    ->label('Consecutivo')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('factura')
                    ->label('Factura')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('proveedor.nombre')
                    ->label('Proveedor')
                    ->searchable(),

                TextColumn::make('requisicion')
                    ->searchable(),

                TextColumn::make('tipoCompra.nombre')
                    ->label('Tipo de Compra'),

                TextColumn::make('fecha_factura')
                    ->label('Fecha de Factura')
                    ->dateTime('d/m/Y')
                    ->sortable(),

                // TextColumn::make('activos_count')
                //     ->label('Activos')
                //     ->counts('activos'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
             ->defaultSort('id', 'desc') // Aplica el orden aquí
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                ExportAction::make('exportar')
                    ->label('Exportar a Excel')
                    ->exporter(EntradaExporter::class)
                    ->formats([ExportFormat::Xlsx])
                    ->columnMapping(false),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
