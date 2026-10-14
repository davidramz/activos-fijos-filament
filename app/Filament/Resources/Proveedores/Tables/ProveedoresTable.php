<?php

namespace App\Filament\Resources\Proveedores\Tables;

use App\Filament\Exports\ProveedorExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProveedoresTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('codigo')
                    ->searchable(),
                TextColumn::make('nombre')
                    ->searchable(),
                TextColumn::make('rfc')
                    ->searchable(),
                TextColumn::make('calle')
                    ->searchable(),
                TextColumn::make('colonia')
                    ->searchable(),
                TextColumn::make('cp')
                    ->searchable(),
                TextColumn::make('ciudad')
                    ->searchable(),
                TextColumn::make('estado')
                    ->searchable(),
                TextColumn::make('telefono')
                    ->searchable(),
                TextColumn::make('giro')
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
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                ExportAction::make('exportar')
                    ->label('Exportar a Excel')
                    ->exporter(ProveedorExporter::class)
                    ->formats([ExportFormat::Xlsx])
                    ->columnMapping(false),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
