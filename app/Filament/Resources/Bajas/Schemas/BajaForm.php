<?php

namespace App\Filament\Resources\Bajas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;

class BajaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('empleado_id')
                    ->label('Empleado')
                    ->relationship('empleado', 'nombre')
                    ->searchable(['nombre', 'numero'])
                    ->required()
                    ->columnSpan(1)
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('activos', [])),
                Hidden::make('user_id')
                    ->default(fn() => auth()->id()),
                Textarea::make('detalles')
                    ->label('Detalles de la Baja')
                    ->placeholder('Observaciones adicionales')
                    ->columnSpanFull(),
                CheckboxList::make('activos')
                    ->label('Activos a Dar de Baja')
                    ->relationship('activos', 'numero_inventario', function ($query, callable $get) {
                        $empleadoId = $get('empleado_id');
                        $query->where('status_id', 2)
                            ->with('material')
                            ->when($empleadoId, function ($query) use ($empleadoId) {
                                $query->where('empleado_actual_id', $empleadoId);
                            }, function ($query) {
                                $query->where('empleado_actual_id','empty');
                            });
                    })
                    ->getOptionLabelFromRecordUsing(function ($record) {
                        return "{$record->numero_inventario} - {$record->material?->nombre} ({$record->numero_serie})";
                    })
                    ->required()
                    ->reactive()
                    ->searchable()
                    ->disabled(fn (callable $get) => !$get('empleado_id'))
                    ->columnSpanFull()
                    ->helperText('Selecciona los activos a dar de baja.'),
            ]);
    }
}
