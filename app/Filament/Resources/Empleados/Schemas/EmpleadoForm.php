<?php

namespace App\Filament\Resources\Empleados\Schemas;

use App\Models\Area;
use App\Models\Campus;
use App\Models\Puesto;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;

class EmpleadoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->placeholder('Nombre y Apellidos')
                    ->required(),
                TextInput::make('numero')
                    ->label('Número')
                    ->placeholder('Número de empleado')
                    ->required()
                    ->numeric(),
                Select::make('area_id')
                    ->label('Área')
                    ->relationship('area', 'nombre')
                    ->searchable('nombre')
                    ->required()
                    ->createOptionModalHeading('Nueva Area')
                    ->createOptionForm([
                        TextInput::make('nombre')
                            ->placeholder('Nombre de la nueva área')
                            ->required()
                            ->afterStateUpdated(function ($state, $set) {
                                $set('nombre', preg_replace('/\s+/', ' ', trim($state)));
                            })
                            ->unique(ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'Ya se encuentra registrada.',
                            ]),
                    ])
                    ->preload(),
                Select::make('puesto_id')
                    ->label('Puesto')
                    ->relationship('puesto', 'nombre')
                    ->createOptionModalHeading('Nuevo Puesto')
                    ->createOptionForm([
                        TextInput::make('nombre')
                            ->placeholder('Nombre del nuevo puesto')
                            ->required()
                            ->afterStateUpdated(function ($state, $set) {
                                $set('nombre', preg_replace('/\s+/', ' ', trim($state)));
                            })
                            ->unique(ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'Ya se encuentra registrado.',
                            ]),
                    ])
                    ->preload()
                    //->options(Puesto::query()->pluck('nombre', 'id'))
                    ->searchable('nombre')
                    ->required(),
                Select::make('campus_id')
                    ->label('Campus')
                    ->options(Campus::query()->pluck('nombre', 'id'))
                    ->required()
            ]);
    }
}
