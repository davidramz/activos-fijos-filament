<?php

namespace App\Filament\Resources\Empleados\Tables;

use App\Filament\Exports\EmpleadoExporter;
use App\Filament\Exports\Enums\NetworkExportFormat;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
class EmpleadosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->paginated([10, 25, 50, 100, 200])
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
                SelectFilter::make('area_id')
                    ->label('Área')
                    ->relationship('area', 'nombre'),
                SelectFilter::make('puesto_id')
                    ->label('Puesto')
                    ->relationship('puesto', 'nombre'),
                SelectFilter::make('campus_id')
                    ->label('Campus')
                    ->relationship('campus', 'nombre'),
            ])
            ->toolbarActions([
                ExportAction::make('exportar')
                    ->label('Exportar a Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->extraAttributes(['class' => 'export-excel-action'])
                    ->exporter(EmpleadoExporter::class)
                    ->formats([NetworkExportFormat::Xlsx])
                    ->columnMapping(false),
                BulkActionGroup::make([
                    //DeleteBulkAction::make(),
                ]),
            ])
            ->recordActions([
                // ViewAction::make(),
                // EditAction::make(),
            ]);
    }
}
