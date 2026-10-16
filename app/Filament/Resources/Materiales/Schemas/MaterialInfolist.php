<?php

namespace App\Filament\Resources\Materiales\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MaterialInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(5)
            ->components([
                
                TextEntry::make('codigo')
                    ->columnSpan(1),

                TextEntry::make('nombre')
                    ->label('Material')
                    ->columnSpan(4),              

                TextEntry::make('tipo.nombre')
                    ->label('Tipo')
                    ->placeholder('-'),

                TextEntry::make('unidad.nombre')
                    ->label('Unidad'),                
                
                TextEntry::make('marca'),

                TextEntry::make('modelo'),                
                
                TextEntry::make('partida.descripcion')
                    ->label('Partida')
                    ->columnSpanFull(),
                // TextEntry::make('created_at')
                //     ->dateTime()
                //     ->placeholder('-'),
                // TextEntry::make('updated_at')
                //     ->dateTime()
                //     ->placeholder('-'),
            ]);
    }
}
