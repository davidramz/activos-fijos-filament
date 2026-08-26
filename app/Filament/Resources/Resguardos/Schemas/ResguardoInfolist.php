<?php

namespace App\Filament\Resources\Resguardos\Schemas;

//use Filament\Infolists\Components\Section;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Infolist;
use Filament\Schemas\Schema;

class ResguardoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información del Resguardo')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('folio_formateado')
                            ->label('Folio')
                            ->copyable(),
                        TextEntry::make('tipo.nombre')
                            ->label('Tipo de Resguardo'),
                        TextEntry::make('empleadoOrigen.nombre')
                            ->label('Empleado'),
                        TextEntry::make('empleadoOrigen.numero')
                            ->label('Número de Empleado'),
                        TextEntry::make('user.name')
                            ->label('Creado por'),
                        TextEntry::make('created_at')
                            ->label('Fecha de Creación')
                            ->dateTime(),
                    ]),
                Section::make('Activos Resguardados')                
                    ->columnSpanFull()
                    ->schema([
                        RepeatableEntry::make('activos')
                            ->schema([
                                TextEntry::make('material.nombre')
                                    ->label('Material')
                                    ->columnSpanFull(),
                                TextEntry::make('numero_inventario')
                                    ->label('Número de Inventario'),
                                TextEntry::make('numero_serie')
                                    ->label('Número de Serie'),
                                TextEntry::make('material.marca')
                                    ->label('Marca'),
                                TextEntry::make('material.modelo')
                                    ->label('Modelo'),
                                TextEntry::make('costo')
                                    ->label('Costo')
                                    ->money('MXN'),
                            ])
                            ->columns(4),
                    ]),
                Section::make('')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('observaciones')
                            ->label('')
                    ]),                    
            ]);
    }
}
