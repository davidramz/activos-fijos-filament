<?php

namespace App\Filament\Resources\Empleados\Tables;

use App\Filament\Exports\EmpleadoExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EmpleadosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('numero')
                    // ->numeric()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nombre')
                    ->searchable(),
                TextColumn::make('area.nombre')
                    ->searchable()
                    // ->numeric()
                    ->sortable(),
                TextColumn::make('puesto.nombre')
                    ->searchable()
                    // ->numeric()
                    ->sortable(),
                TextColumn::make('campus.nombre')
                    ->searchable()
                    // ->numeric()
                    ->sortable(),
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
            ->toolbarActions([
                ExportAction::make('exportar')
                    ->label('Exportar a Excel')
                    ->exporter(EmpleadoExporter::class)
                    ->formats([ExportFormat::Xlsx])
                    ->columnMapping(false),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->recordActions([
                // ViewAction::make(),
                // EditAction::make(),
            ]);
    }
}
