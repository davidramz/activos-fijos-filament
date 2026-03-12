<?php

namespace App\Filament\Resources\Unidads\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UnidadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required()
                    ->afterStateUpdated(function ($state, $set) {
                        $set('nombre', preg_replace('/\s+/', ' ', trim($state)));
                    })
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'unique' => 'Ya se encuentra registrado.',
                    ]),
            ]);
    }
}
