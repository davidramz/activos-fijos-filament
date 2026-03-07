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
                    ->options(Area::query()->pluck('nombre', 'id'))
                    ->searchable('nombre')
                    ->required(),
                Select::make('puesto_id')
                    ->label('Puesto')
                    ->options(Puesto::query()->pluck('nombre', 'id'))
                    ->searchable('nombre')
                    ->required(),
                Select::make('campus_id')
                    ->label('Campus')
                    ->options(Campus::query()->pluck('nombre', 'id'))
                    ->required()
            ]);
    }
}
