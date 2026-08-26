<?php

namespace App\Filament\Resources\Empleados\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
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
                Section::make('Activos asignados')
                    ->columnSpanFull()
                    ->schema([
                        RepeatableEntry::make('activosActuales')
                            ->label('')
                            ->schema([
                                TextEntry::make('material.nombre')
                                    ->label('Material')
                                    ->columnspanFull(),
                                TextEntry::make('numero_inventario')
                                    ->label('Número de inventario'),                                
                                TextEntry::make('numero_serie')
                                    ->label('Número de serie')
                                    ->placeholder('-'),
                                TextEntry::make('status.nombre')
                                    ->label('Estado')
                                    ->badge(),
                                TextEntry::make('costo')
                                    ->label('Costo')
                                    ->money('MXN'),
                            ])
                            ->columns(5)
                            ->placeholder('No tiene activos asignados.'),
                    ]),
            ]);
    }
}
