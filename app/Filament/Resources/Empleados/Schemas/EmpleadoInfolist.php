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
                TextEntry::make('nombre'),
                TextEntry::make('numero'),
                TextEntry::make('area.nombre')
                    ->label('Área'),
                TextEntry::make('puesto.nombre')
                    ->label('Puesto'),
                TextEntry::make('campus.nombre')
                    ->label('Campus'),
                TextEntry::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
