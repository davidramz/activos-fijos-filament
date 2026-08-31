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
            ->columns(2)
            ->components([
                Hidden::make('tipo_id')
                    ->default(1),
                Select::make('empleado_origen_id')
                    ->label('Empleado')
                    ->relationship('empleadoOrigen', 'nombre')
                    ->searchable(['nombre', 'numero'])
                    ->required()
                    ->validationMessages([
                            'required' => 'El :attribute es requerido.',
                        ])
                    ->columnSpan(1),
                Hidden::make('user_id')
                    ->default(fn() => auth()->id()),
                Textarea::make('observaciones')
                    ->label('Observaciones')
                    ->placeholder('Observaciones adicionales')
                    ->columnSpanFull(),
                Select::make('activos')
                    ->label('Activos a Resguardar')
                    ->relationship('activos', 'numero_inventario')
                    ->reorderable()
                    ->multiple()
                    ->getSearchResultsUsing(function(string $search): array {
                        return \App\Models\Activo::query()
                            ->where('status_id', 1)
                            ->with('material')
                            ->where(function($q) use ($search) {
                                $q->where('numero_inventario', 'like', "%{$search}%")
                                    ->orWhere('numero_serie', 'like', "%{$search}%")
                                    ->orWhereHas('material', fn($q) => $q->where('nombre', 'like', "%{$search}%"));
                            })
                            ->limit(20)
                            ->get()
                            ->mapWithKeys(fn($record) => [
                                $record->id => "{$record->numero_inventario} - {$record->material?->nombre} ({$record->numero_serie})"
                            ])
                            ->toArray();
                    })
                    ->getOptionLabelUsing(function($value) {
                        $record = \App\Models\Activo::with('material')->find($value);
                        return $record ? "{$record->numero_inventario} - {$record->material?->nombre} ({$record->numero_serie})" : $value;
                    })
                    ->required()
                    ->validationMessages([
                            'required' => 'El :attribute es requerido.',
                        ])
                    ->columnSpanFull()
                    ->helperText('Busca por número de inventario, serie o nombre del material')
                    ->optionsLimit(20),
            ]);
    }
}
