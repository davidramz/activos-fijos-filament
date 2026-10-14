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
                    ->label('Compra'),

                TextColumn::make('fecha_factura')
                    ->label('Fecha Factura')
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
             ->defaultSort('consecutivo', 'desc') // Aplica el orden aquí
            ->filters([
                //
            ])
            ->recordActions([
                // ViewAction::make(),
                // EditAction::make(),
            ])
            ->toolbarActions([
                ExportAction::make('exportar')
                    ->label('Exportar a Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->extraAttributes(['class' => 'export-excel-action'])
                    ->exporter(EntradaExporter::class)
                    ->formats([ExportFormat::Xlsx])
                    ->columnMapping(false)
                    //->extraAttributes(['class' => 'fi-color fi-color-primary fi-bg-color-400 hover:fi-bg-color-300 dark:fi-bg-color-600 dark:hover:fi-bg-color-700 fi-text-color-50 hover:fi-text-color-900 dark:fi-text-color-0 dark:hover:fi-text-color-0 fi-btn fi-size-md  fi-ac-btn-action']),
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
