<?php

namespace App\Filament\Resources\Resguardos\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;

class ResguardoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // TextInput::make('folio')
                //     ->required()
                //     ->numeric(),
                // TextInput::make('anio')
                //     ->required()
                //     ->numeric(),
                // Hidden::make('anio')
                //     ->default(fn() => date('Y')),
                Select::make('tipo_id')
                    ->label('Tipo de Resguardo')
                    ->required()
                    ->relationship('tipo', 'nombre')
                    ->searchable(['nombre']),
                Select::make('empleado_id')
                    ->label('Empleado')
                    ->required()
                    ->relationship('empleado', 'nombre')
                    ->searchable(['nombre', 'numero']),
                Hidden::make('user_id')
                    ->default(fn() => auth()->id()),
                Textarea::make('observaciones')
                    ->columnSpanFull(),
                Select::make('activos')
                    ->label('Activos')
                    ->relationship(
                        'activos',
                        'numero_inventario',
                        modifyQueryUsing: fn($query) => $query->where('status', 'ALMACEN')
                    )
                    ->multiple()
                    ->searchable(['numero_inventario', 'numero_serie'])
                    ->columnSpanFull(),
            ]);
    }
}
