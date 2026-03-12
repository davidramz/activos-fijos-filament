<?php

namespace App\Filament\Resources\Materials\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MaterialInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('tipo')
                    ->placeholder('-'),
                TextEntry::make('partida.descripcion')
                    ->label('Partida')
                    ->columnSpanFull(),
                TextEntry::make('unidad.nombre')
                    ->label('Unidad'),
                TextEntry::make('codigo'),
                TextEntry::make('nombre')
                    ->label('Nombre del material')
                    ->columnSpanFull(),
                TextEntry::make('marca'),
                TextEntry::make('modelo'),
                // TextEntry::make('created_at')
                //     ->dateTime()
                //     ->placeholder('-'),
                // TextEntry::make('updated_at')
                //     ->dateTime()
                //     ->placeholder('-'),
            ]);
    }
}
