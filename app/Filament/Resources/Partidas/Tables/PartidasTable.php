<?php

namespace App\Filament\Resources\Partidas\Tables;

use App\Filament\Exports\PartidaExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;
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
            ->columns([
                TextColumn::make('tipo.nombre')->label('Tipo')
                    ->searchable(),
                TextColumn::make('codigo') 
                    ->searchable(),
                TextColumn::make('nombre')
                    ->limit(50) 
                    ->searchable(),
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
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                ExportAction::make('exportar')
                    ->label('Exportar a Excel')
                    ->exporter(PartidaExporter::class)
                    ->formats([ExportFormat::Xlsx])
                    ->columnMapping(false),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
