<?php

namespace App\Filament\Resources\Activos\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ActivoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('material_id')
                    ->label('Material')
                    ->required()
                    ->relationship('material', 'nombre')
                    ->searchable(['nombre', 'codigo', 'marca'])
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->nombre} - {$record->marca} ({$record->modelo})")
                    ->columnSpanFull(),

                TextInput::make('numero_inventario')
                    ->label('Número de Inventario')
                    ->required(),

                TextInput::make('numero_serie')
                    ->label('Número de Serie'),

                TextInput::make('costo')
                    ->label('Costo')
                    ->numeric()
                    ->prefix('$'),

                DatePicker::make('garantia')
                    ->label('Garantía'),

                Select::make('status')
                    ->label('Estado')
                    ->required()
                    ->options([
                        'Disponible' => 'Disponible',
                        'En uso' => 'En uso',
                        'Dañado' => 'Dañado',
                        'Fuera de servicio' => 'Fuera de servicio',
                    ]),

                Select::make('current_empleado_id')
                    ->label('Asignado a')
                    ->relationship('empleadoActual', 'nombre')
                    ->searchable(['nombre', 'cedula'])
                    ->nullable(),

                Textarea::make('detalles')
                    ->label('Detalles')
                    ->columnSpanFull(),

                FileUpload::make('imagenes')
                    ->label('Imágenes')
                    ->multiple()
                    ->reorderable()
                    ->disk('public')
                    ->directory('activos')
                    ->visibility('public')
                    ->image()
                    ->maxSize(5120)
                    ->columnSpanFull(),
            ]);
    }
}
