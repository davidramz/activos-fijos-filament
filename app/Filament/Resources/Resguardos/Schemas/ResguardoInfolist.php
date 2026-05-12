<?php

namespace App\Filament\Resources\Resguardos\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
//use Filament\Infolists\Components\Section;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\ViewEntry;

class ResguardoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('folioFormateado')
                    ->label('Folio'),
                // TextEntry::make('anio')
                //     ->label('Año'),
                TextEntry::make('empleado.nombre')
                    ->label('Empleado'),
                
                Section::make('Activos')
                    ->columnSpanFull()
                    ->schema([
                        RepeatableEntry::make('activos')
                            ->hiddenLabel()
                            ->schema([
                                TextEntry::make('material.nombre')
                                    ->label('Material')
                                    ->columnSpanFull(),
                                TextEntry::make('numero_inventario')
                                    ->label('Inventario'),
                                TextEntry::make('numero_serie')
                                    ->label('Serie'),
                                TextEntry::make('costo')
                                    ->label('Costo')
                                    ->money('MXN'),
                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge(),
                                    TextEntry::make('garantia')
                                    ->dateTime('d/m/Y')
                                    ->label('garantia'),
                                    ViewEntry::make('imagenes')
                    ->label('Imágenes')
                    ->columnSpanFull()
                    ->view('filament.infolists.components.image-gallery', [
                        // Images will be passed via the record
                    ]),
                            ])
                            ->columns(5),
                    ]),
                    
                TextEntry::make('observaciones')
                    ->placeholder('-'),
                TextEntry::make('user.name')
                    ->label('Creado por'),
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
