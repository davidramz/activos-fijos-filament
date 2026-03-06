<?php

namespace App\Filament\Resources\Puestos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PuestoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required(),
            ]);
    }
}
