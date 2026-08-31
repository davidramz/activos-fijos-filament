<?php

namespace App\Filament\Resources\ResguardoEntreEmpleados\Schemas;

//use Filament\Infolists\Components\Section;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Infolist;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class ResguardoEntreEmpleadosInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información de Resguardo Entre Empleados')
                    ->columnSpanFull()
                    ->columns(5)
                    ->compact()
                    ->schema([
                        TextEntry::make('folio_formateado')
                            ->label('Folio')
                            ->copyable(),
                        // TextEntry::make('tipo.nombre')
                        //     ->label('Tipo de Resguardo'),
                        TextEntry::make('empleadoOrigen.nombre')
                            ->label('Empleado Origen'),
                        TextEntry::make('empleadoDestino.nombre')
                            ->label('Empleado Destino'),
                        // TextEntry::make('empleado.numero')
                        //     ->label('Número de Empleado'),
                        TextEntry::make('created_at')
                            ->label('Fecha de Creación')
                            ->dateTime(),
                        TextEntry::make('user.name')
                            ->label('Creado por'),
                        TextEntry::make('observaciones')
                            ->label('Observaciones')
                            ->columnSpanFull()
                            ->hidden(fn ($record) => empty($record->observaciones)),
                    ]),
                // Section::make('Activos Transferidos')                
                //     ->columnSpanFull()
                //     ->compact()
                //     ->schema([
                //         RepeatableEntry::make('activos')                        
                //             ->hiddenLabel()
                //             ->schema([
                //                 TextEntry::make('material.nombre')
                //                     ->weight(FontWeight::Bold)
                //                     ->hiddenLabel()
                //                     ->columnSpanFull(),
                //                 TextEntry::make('numero_inventario')
                //                     ->label('Inventario'),
                //                 TextEntry::make('numero_serie')
                //                     ->label('Número de Serie'),
                //                 TextEntry::make('material.marca')
                //                     ->label('Marca'),
                //                 TextEntry::make('material.modelo')
                //                     ->label('Modelo'),
                //                 TextEntry::make('material.codigo')
                //                     ->label('Código'),
                //                 TextEntry::make('costo')
                //                     ->label('Costo')
                //                     ->money('MXN'),
                //             ])
                //             ->columns(6)
                //     ]),
                // Section::make('Observaciones')
                //     ->columnSpanFull()
                //     ->compact()
                //     ->schema([
                //         TextEntry::make('observaciones')
                //             ->hiddenLabel()
                //     ]),                    
            ]);
    }
}
