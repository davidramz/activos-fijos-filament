<?php

namespace App\Filament\Resources\Partidas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;

class PartidaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(6)
            ->components([
                
                TextEntry::make('tipo.nombre')
                    ->label('Tipo de Partida')
                    ->columnSpanFull(),

                TextEntry::make('codigo')->label('Código')
                    ->columnSpan(1),

                TextEntry::make('nombre')
                    ->columnSpan(5),
                
                TextEntry::make('detalle')
                    ->columnSpanFull()
                    ->placeholder('-'),
                // TextEntry::make('created_at')
                //     ->dateTime()
                //     ->placeholder('-'),
                // TextEntry::make('updated_at')
                //     ->dateTime()
                //     ->placeholder('-'),
            ]);
    }
}
