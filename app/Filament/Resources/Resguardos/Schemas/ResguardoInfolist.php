<?php

namespace App\Filament\Resources\Resguardos\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ResguardoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('folio')
                    ->numeric(),
                TextEntry::make('anio')
                    ->label('Año'),
                TextEntry::make('empleado.nombre')
                    ->label('Empleado'),
                TextEntry::make('user.name')
                    ->label('Creado por'),
                TextEntry::make('observaciones')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->label('Creado el')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('Actualizado el')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
