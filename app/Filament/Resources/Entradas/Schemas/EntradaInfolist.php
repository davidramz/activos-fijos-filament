<?php

namespace App\Filament\Resources\Entradas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EntradaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                TextEntry::make('folio')
                    ->label('Folio'),

                TextEntry::make('proveedor.nombre')
                    ->label('Proveedor'),

                TextEntry::make('requisicion')
                    ->label('Requisición'),

                TextEntry::make('tipo_compra')
                    ->label('Tipo de Compra'),

                TextEntry::make('fecha_factura')
                    ->label('Fecha de Factura')
                    ->dateTime('d/m/Y'),

                TextEntry::make('user.name')
                    ->label('Usuario'),

                TextEntry::make('created_at')
                    ->label('Creado el')
                    ->dateTime('d/m/Y H:i'),

                TextEntry::make('updated_at')
                    ->label('Actualizado el')
                    ->dateTime('d/m/Y H:i'),
            ]);
    }
}
