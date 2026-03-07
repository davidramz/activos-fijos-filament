<?php

namespace App\Filament\Resources\Proveedors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProveedorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('codigo')
                    ->required(),
                TextInput::make('nombre')
                    ->required(),
                TextInput::make('rfc'),
                TextInput::make('calle'),
                TextInput::make('colonia'),
                TextInput::make('cp'),
                TextInput::make('ciudad'),
                TextInput::make('estado'),
                TextInput::make('telefono')
                    ->tel(),
                TextInput::make('giro'),
            ]);
    }
}
