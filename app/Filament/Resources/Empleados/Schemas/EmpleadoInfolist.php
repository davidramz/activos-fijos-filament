<?php

namespace App\Filament\Resources\Empleados\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class EmpleadoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema        
            ->columns(6)
            ->components([
                TextEntry::make('numero')
                    ->label('No. Empleado')
                    ->columns(1),
                TextEntry::make('nombre')
                    ->columns(3),
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
                Section::make('Activos Asignados')
                    ->columnSpanFull()
                    ->compact()
                    ->schema([
                        RepeatableEntry::make('activosActuales')
                            ->hiddenLabel()
                            ->schema([
                                TextEntry::make('material.nombre')
                                    ->hiddenLabel()
                                    ->weight(FontWeight::Bold)
                                    ->columnSpanFull(),
                                TextEntry::make('numero_inventario')
                                    ->label('Inventario'),
                                TextEntry::make('numero_serie')
                                    ->label('Número de Serie'),
                                TextEntry::make('material.marca')
                                    ->label('Marca'),
                                TextEntry::make('material.modelo')
                                    ->label('Modelo'),
                                TextEntry::make('material.codigo')
                                    ->label('Código'),
                                TextEntry::make('costo')
                                    ->label('Costo')
                                    ->money('MXN'),
                            ])
                            ->columns(6)
                            ->placeholder('No tiene activos asignados.'),
                    ]),
            ]);
    }
}
