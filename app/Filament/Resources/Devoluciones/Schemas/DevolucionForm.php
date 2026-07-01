<?php

namespace App\Filament\Resources\Devoluciones\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;

class DevolucionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
        
            ->columns(2)
            ->components([
                Hidden::make('tipo_id')
                    ->default(2),
                Select::make('empleado_id')
                    ->label('Empleado')
                    ->relationship('empleado', 'nombre')
                    ->searchable(['nombre', 'numero'])
                    ->required()
                    ->columnSpan(1)
                    ->reactive()
                    ->afterStateUpdated(function ($livewire) {
                        $livewire->validateOnly('empleado_id');
                    }),
                Hidden::make('user_id')
                    ->default(fn() => auth()->id()),
                Textarea::make('observaciones')
                    ->label('Observaciones')
                    ->placeholder('Observaciones adicionales')
                    ->columnSpanFull(),
                Select::make('activos')
                    ->label('Activos a Devolver')
                    ->relationship('activos', 'numero_inventario')
                    ->multiple()
                    ->getSearchResultsUsing(function(string $search, $state): array {
                        $query = \App\Models\Activo::query()
                            ->where('status_id', 2)
                            ->with('material');

                        // Filtrar por empleado seleccionado si existe
                        if ($state && isset($state['empleado_id'])) {
                            $query->where('empleado_actual_id', $state['empleado_id']);
                        }

                        $query->where(function($q) use ($search) {
                            $q->where('numero_inventario', 'like', "%{$search}%")
                                ->orWhere('numero_serie', 'like', "%{$search}%")
                                ->orWhereHas('material', fn($q) => $q->where('nombre', 'like', "%{$search}%"));
                        });

                        return $query->limit(20)
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
                    ->columnSpanFull()
                    ->helperText('Busca por número de inventario, serie o nombre del material')
                    ->optionsLimit(20),
            ]);
    }
}
