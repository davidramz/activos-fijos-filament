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
                    ->label('Tipo de Movimiento')
                    ->required()
                    ->relationship('tipo', 'nombre')
                    ->searchable(['nombre'])
                    ->disabled()
                    ->default(1),
                // Hidden::make('tipo_id')
                //     ->default(1),
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
                        modifyQueryUsing: fn($query) => $query->where('status_id', 1)
                    )
                    ->multiple()
                    ->searchable(['numero_inventario', 'numero_serie', 'nombre'])
                    ->columnSpanFull(),
            ]);
    }
}
