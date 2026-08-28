<?php

namespace App\Filament\Resources\Bajas\Schemas;

//use Filament\Infolists\Components\Section;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Infolist;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class BajaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información del Baja')
                    ->columnSpanFull()
                    ->compact()
                    ->columns(4)
                    ->schema([
                        TextEntry::make('folio_formateado')
                            ->label('Folio')
                            ->copyable(),
                        //TextEntry::make('Baja'),
                        // TextEntry::make('empleado.numero')
                        //     ->label('No.Empleado'),
                        TextEntry::make('empleado.nombre')
                            ->label('Empleado'),
                        TextEntry::make('created_at')
                            ->label('Fecha de Creación')
                            ->dateTime(),
                        TextEntry::make('user.name')
                            ->label('Creado por'),
                    ]),
                Section::make('Activos Resguardados')                
                    ->columnSpanFull()
                    ->compact()
                    ->schema([
                        RepeatableEntry::make('activos')
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
                    ]),
                Section::make('Observaciones')
                    ->columnSpanFull()
                    ->compact()
                    ->schema([
                        TextEntry::make('detalles')
                            ->hiddenLabel()
                    ]),                    
            ]);
    }
}
