<?php

namespace App\Filament\Resources\Partidas\Tables;

use App\Filament\Exports\PartidaExporter;
use App\Filament\Exports\Enums\NetworkExportFormat;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;

class PartidasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->paginated([10, 25, 50, 100, 200])
            ->columns([
                TextColumn::make('tipo.nombre')->label('Tipo')
                    ->searchable()->sortable(),
                TextColumn::make('codigo') 
                    ->searchable()->sortable(),
                TextColumn::make('nombre')
                    ->limit(50) 
                    ->searchable()->sortable(),
                TextColumn::make('detalle')
                    ->limit(50) 
                    ->searchable(),
                // TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                //ViewAction::make(),
                //EditAction::make(),
            ])
            ->toolbarActions([
                ExportAction::make('exportar')
                    ->label('Exportar a Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->extraAttributes(['class' => 'export-excel-action'])
                    ->exporter(PartidaExporter::class)
                    ->formats([NetworkExportFormat::Xlsx])
                    ->columnMapping(false),
                BulkActionGroup::make([
                    //DeleteBulkAction::make(),
                ]),
            ]);
    }
}
