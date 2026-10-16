<?php

namespace App\Filament\Resources\Materiales\Schemas;

use App\Models\Partida;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;

class MaterialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tipo_id')
                    ->required()
                    ->relationship('tipo', 'nombre'),
                Select::make('partida_id')
                    ->label('Partida')
                    ->required()
                    ->relationship('partida', 'descripcion')
                    ->searchable(['codigo', 'nombre'])
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->descripcion)
                    ->searchPrompt('Buscar por código o nombre...')
                    ->searchDebounce(500)
                    ->columnSpanFull()
                    ->createOptionForm([
                        TextInput::make('codigo')
                            ->required(),
                        Select::make('tipo')
                            ->required()
                            ->options([
                                'Interno' => 'Interno',
                                'Patrimonio' => 'Patrimonio'
                            ]),
                        TextInput::make('nombre')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('detalle')
                            ->columnSpan(2),
                    ]),
                Select::make('unidad_id')
                    ->required()
                    ->relationship('unidad', 'nombre')
                    ->searchable()
                    ->searchPrompt('Buscar por nombre...')
                    ->searchDebounce(500)
                    ->createOptionForm([
                        TextInput::make('nombre')
                            ->required()
                            ->afterStateUpdated(function ($state, $set) {
                                $set('nombre', preg_replace('/\s+/', ' ', trim($state)));
                            })
                            ->unique(ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'Ya se encuentra registrado.',
                            ]),
                    ]),
                TextInput::make('codigo')
                    ->required()
                    ->extraAttributes([
                        'autocomplete' => 'off',
                    ]),
                TextInput::make('nombre')
                    ->required()
                    ->placeholder('Nombre del material')
                    ->extraAttributes([
                        'autocomplete' => 'off',
                    ])
                    ->columnSpanFull(),
                TextInput::make('marca')
                    ->required()
                    ->extraAttributes([
                        'autocomplete' => 'off',
                    ]),
                TextInput::make('modelo')
                    ->required()
                    ->extraAttributes([
                        'autocomplete' => 'off',
                    ]),
            ]);
    }
}
