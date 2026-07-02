<?php

namespace App\Filament\Resources\Devoluciones\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\CheckboxList;
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
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('activos', []);
                        $set('activos_search', '');
                    }),
                Hidden::make('user_id')
                    ->default(fn() => auth()->id()),
                Textarea::make('observaciones')
                    ->label('Observaciones')
                    ->placeholder('Observaciones adicionales')
                    ->columnSpanFull(),
                TextInput::make('activos_search')
                    ->label('Buscar Activos')
                    ->placeholder('Número inventario, serie o nombre del material')
                    ->reactive()
                    ->columnSpanFull(),

                CheckboxList::make('activos')
                    ->label('Activos a Devolver')
                    ->reactive()
                    ->disabled(fn (callable $get) => !$get('empleado_id'))
                    ->columns(2)
                    ->options(function (callable $get) {
                        $search = $get('activos_search') ?? '';

                        $query = \App\Models\Activo::query()
                            ->where('status_id', 2)
                            ->with('material');

                        $empleadoId = $get('empleado_id');
                        if ($empleadoId) {
                            $query->where('empleado_actual_id', $empleadoId);
                        }

                        if ($search) {
                            $query->where(function($q) use ($search) {
                                $q->where('numero_inventario', 'like', "%{$search}%")
                                  ->orWhere('numero_serie', 'like', "%{$search}%")
                                  ->orWhereHas('material', fn($q) => $q->where('nombre', 'like', "%{$search}%"));
                            });
                            return $query->limit(500)
                            ->get()
                            ->mapWithKeys(fn($record) => [
                                $record->id => "{$record->numero_inventario} - {$record->material?->nombre} ({$record->numero_serie})"
                            ])
                            ->toArray();
                        }else{
                            return $query->where('empleado_actual_id', $empleadoId)
                            ->limit(500)
                            ->get()
                            ->mapWithKeys(fn($record) => [
                                $record->id => "{$record->numero_inventario} - {$record->material?->nombre} ({$record->numero_serie})"
                            ])
                            ->toArray();
                        }

                        
                    })
                    ->columnSpanFull()
                    ->helperText('Activos asignados al empleado. Selecciona uno o varios con las casillas.'),
            ]);
    }
}
