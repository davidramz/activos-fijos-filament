<?php

namespace App\Filament\Resources\Proveedors\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProveedorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('codigo'),
                TextEntry::make('nombre'),
                TextEntry::make('rfc')
                    ->placeholder('-'),
                TextEntry::make('calle')
                    ->placeholder('-'),
                TextEntry::make('colonia')
                    ->placeholder('-'),
                TextEntry::make('cp')
                    ->placeholder('-'),
                TextEntry::make('ciudad')
                    ->placeholder('-'),
                TextEntry::make('estado')
                    ->placeholder('-'),
                TextEntry::make('telefono')
                    ->placeholder('-'),
                TextEntry::make('giro')
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
