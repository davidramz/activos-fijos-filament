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
                TextEntry::make('partida_id')
                    ->numeric(),
                TextEntry::make('unidad_id')
                    ->numeric(),
                TextEntry::make('codigo'),
                TextEntry::make('nombre'),
                TextEntry::make('marca'),
                TextEntry::make('modelo'),
                TextEntry::make('tipo')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
