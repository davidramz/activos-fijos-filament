<?php

namespace App\Filament\Resources\Partidas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PartidaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('codigo')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'unique' => 'El :attribute ya se encuentra registrado.',
                    ]),
                Select::make('tipo_id')
                    ->required()
                    ->relationship('tipo', 'nombre'),
                TextInput::make('nombre')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('detalle')
                    ->columnSpan(2),
            ]);
    }
}
