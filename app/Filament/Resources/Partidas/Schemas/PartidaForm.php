<?php

namespace App\Filament\Resources\Partidas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PartidaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('codigo')
                    ->required(),
                TextInput::make('tipo')
                    ->required(),
                TextInput::make('nombre')
                    ->required(),
                TextInput::make('detalle'),
            ]);
    }
}
