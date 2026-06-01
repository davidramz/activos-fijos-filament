<?php

namespace App\Filament\Resources\Partidas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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
                    // ->size(TextSize::ExtraSmall)    
                    // ->weight(FontWeight::ExtraLight)
                    ->searchable(),
                TextColumn::make('codigo')
                    // ->size(TextSize::ExtraSmall)    
                    ->searchable(),
                TextColumn::make('nombre')
                    //->size(TextSize::ExtraSmall)    
                    ->searchable(),
                TextColumn::make('detalle')
                    // ->size(TextSize::ExtraSmall)    
                    // ->weight(FontWeight::ExtraLight)
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
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
