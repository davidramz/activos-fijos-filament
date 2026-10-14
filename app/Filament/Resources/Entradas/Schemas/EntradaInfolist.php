<?php

namespace App\Filament\Resources\Entradas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class EntradaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([     
                Section::make('')
                    ->columns(8)
                    ->compact()
                    ->schema([           
                        TextEntry::make('consecutivo')
                            ->label('No. Entrada'),

                        TextEntry::make('proveedor.nombre')
                            ->label('Proveedor'),

                        TextEntry::make('proveedor.rfc')
                            ->label('RFC'),

                        TextEntry::make('factura')
                            ->label('Factura'),

                        TextEntry::make('requisicion')
                            ->label('Requisición'),

                        TextEntry::make('tipoCompra.nombre')
                            ->label('Tipo de Compra'),

                        TextEntry::make('fecha_factura')
                            ->label('Fecha Factura')
                            ->dateTime('d/m/Y'),
                            
                        TextEntry::make('created_at')
                            ->label('Fecha Entrada')
                            ->dateTime('d/m/Y'),

                        // TextEntry::make('user.name')
                        //     ->label('Usuario'),                  
                        // TextEntry::make('updated_at')
                        //     ->label('Actualizado el')
                        //     ->dateTime('d/m/Y H:i'),                
                    ]),                
            ]);
    }
}
