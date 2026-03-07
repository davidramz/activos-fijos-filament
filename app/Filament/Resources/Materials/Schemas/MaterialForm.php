<?php

namespace App\Filament\Resources\Materials\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MaterialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('partida_id')
                    ->label('Partida')
                    ->required()
                    ->numeric(),
                TextInput::make('unidad_id')
                    ->required()
                    ->numeric(),
                TextInput::make('codigo')
                    ->required(),
                TextInput::make('nombre')
                    ->required(),
                TextInput::make('marca')
                    ->required(),
                TextInput::make('modelo')
                    ->required(),
                TextInput::make('tipo'),
            ]);
    }
}
