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
                    ->disabled(fn (callable $get) => !$get('empleado_id'))
                    ->columnSpanFull(),

                CheckboxList::make('activos')
                    ->label('Activos a Devolver')
                    ->relationship('activos', 'numero_inventario', function ($query, callable $get) {
                        $search = $get('activos_search') ?? '';
                        $query->where('status_id', 2)
                            ->with('material');

                        $empleadoId = $get('empleado_id');
                        if (!$empleadoId) {
                            $query->whereNull('empleado_actual_id');
                        }else {
                            $query->where('empleado_actual_id', $empleadoId);                            
                        }

                        if ($search) {
                            $query->where(function ($q) use ($search) {
                                $q->where('numero_inventario', 'like', "%{$search}%")
                                  ->orWhere('numero_serie', 'like', "%{$search}%")
                                  ->orWhereHas('material', fn ($q) => $q->where('nombre', 'like', "%{$search}%"));
                            });
                        }

                        return $query;
                    })
                    ->getOptionLabelFromRecordUsing(function ($record) {
                        return "{$record->numero_inventario} - {$record->material?->nombre} ({$record->numero_serie})";
                    })
                    ->reactive()
                    ->disabled(fn (callable $get) => !$get('empleado_id'))
                    ->columnSpanFull()
                    ->helperText('Activos asignados al empleado. Selecciona uno o varios con las casillas.'),
            ]);
    }
}
