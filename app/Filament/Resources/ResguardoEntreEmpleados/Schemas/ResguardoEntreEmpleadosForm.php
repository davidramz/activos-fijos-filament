<?php

namespace App\Filament\Resources\ResguardoEntreEmpleados\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class ResguardoEntreEmpleadosForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
        
            ->columns(2)
            ->components([
                Hidden::make('tipo_id')
                    ->default(3),
                Select::make('empleado_origen_id')
                    ->label('Empleado Origen')                    
                    ->placeHolder('Buscar por número o nombre')
                    ->relationship('empleadoOrigen', 'nombre')
                    ->searchable(['nombre', 'numero'])
                    ->required()
                    ->validationMessages([
                            'required' => 'El :attribute es requerido.',
                        ])
                    ->columnSpan(1)
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('activos', []);
                        $set('activos_search', '');
                    }),
                Select::make('empleado_destino_id')
                    ->label('Empleado Destino')
                    ->placeHolder('Buscar por número o nombre')
                    ->relationship('empleadoDestino', 'nombre')
                    ->searchable(['nombre', 'numero'])
                    ->required()
                    ->validationMessages([
                            'required' => 'El :attribute es requerido.',
                        ])
                    ->columnSpan(1)
                    ->reactive(),
                Hidden::make('user_id')
                    ->default(fn() => auth()->id()),
                
                // TextInput::make('activos_search')
                //     ->label('Buscar Activos')
                //     ->placeholder('Número inventario, serie o nombre del material')
                //     ->reactive()
                //     ->disabled(fn (callable $get) => !$get('empleado_id'))
                //     ->columnSpanFull(),
                Section::make()
                    ->columnSpanFull()                    
                    ->extraAttributes(['class'=>'section-movimientos'])
                    ->schema([
                        CheckboxList::make('activos')
                            ->hiddenLabel()
                            ->required()
                            ->validationMessages([
                                    'required' => 'Campo requerido. Debes seleccionar al menos un activo.',
                                ])
                            //->label('Selecciona uno o varios con las casillas.')
                            ->relationship('activos', 'numero_inventario', function ($query, callable $get) {
                                    $search = $get('activos_search') ?? '';
                                    $query->where('status_id', 2)
                                        ->with('material');

                                    $empleadoId = $get('empleado_origen_id');
                                    if (!$empleadoId) {
                                        $query->where('empleado_actual_id','empty');
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
                            ->searchable()
                            ->disabled(fn (callable $get) => !$get('empleado_origen_id'))
                            ->columnSpanFull()                            
                            ]),
                Textarea::make('observaciones')
                    ->label('Observaciones')
                    ->placeholder('Observaciones adicionales')
                    ->columnSpanFull(),
                
            ]);
    }
}
