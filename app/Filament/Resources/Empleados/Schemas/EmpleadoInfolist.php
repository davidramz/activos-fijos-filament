<?php

namespace App\Filament\Resources\Empleados\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EmpleadoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('area_id')
                    ->numeric(),
                TextEntry::make('puesto_id')
                    ->numeric(),
                TextEntry::make('campus_id')
                    ->numeric(),
                TextEntry::make('numero')
                    ->numeric(),
                TextEntry::make('nombre'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
