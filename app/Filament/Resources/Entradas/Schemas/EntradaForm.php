<?php

namespace App\Filament\Resources\Entradas\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class EntradaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('proveedor_id')
                    ->label('Proveedor')
                    ->required()
                    ->validationMessages([
                        'required' => 'Se requiere un proveedor.',
                    ])
                    ->relationship('proveedor', 'nombre')
                    ->searchable(['nombre', 'codigo', 'rfc'])
                    ->columnSpan(2),

                TextInput::make('folio')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'required' => 'Se requiere un folio.',
                        'unique' => 'El folio ya existe.',
                    ]),

                TextInput::make('requisicion')
                    ->label('Requisición')
                    ->required()
                    ->validationMessages([
                        'required' => 'Se requiere una requisición.',
                    ]),

                Select::make('tipo_compra')
                    ->options([
                        'directa' => 'directa',
                        'licitación' => 'licitación',
                        'consolidada' => 'consolidada',
                        'donación' => 'donación',
                        'promoción' => 'promoción',
                        'otra' => 'otra',
                    ])
                    ->validationMessages([
                        'required' => 'Seleccione una opción tipo de compra.',
                    ]),

                DatePicker::make('fecha_factura')
                    ->label('Fecha de Factura')
                    ->required()
                    ->validationMessages([
                        'required' => 'Se requiere una fecha de factura.',
                    ]),

                Repeater::make('activos')
                    ->label('Activos')
                    ->required()
                    ->validationMessages([
                        'required' => 'Se requiere un activo.',
                    ])
                    ->relationship('activos')
                    ->columnSpanFull()
                    ->schema([
                        Select::make('material_id')
                            ->label('Material')
                            ->required()
                            ->relationship('material', 'nombre')
                            ->searchable(['nombre', 'codigo', 'marca'])
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->nombre} - {$record->marca} ({$record->modelo})")
                            ->columnSpanFull()
                            ->live(onBlur: true),

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

                        Textarea::make('detalles')
                            ->label('Detalles')
                            ->columnSpanFull(),

                        FileUpload::make('imagenes')
                            ->label('Imágenes')
                            ->multiple()
                            ->appendFiles()
                            ->reorderable()
                            ->disk('public')
                            ->directory('activos')
                            ->visibility('public')
                            ->image()
                            ->getUploadedFileNameForStorageUsing(function ($file) {
                                return Str::uuid() . '.' . $file->getClientOriginalExtension();
                            })
                            ->maxSize(5120)
                            ->columnSpanFull(),

                        Select::make('status')
                            ->label('Estado')
                            ->default('Disponible')
                            ->options([
                                'ALMACEN' => 'ALMACEN',
                                'RESGUARDADO' => 'RESGUARDADO',
                                'BAJA' => 'BAJA',
                                'EXTRAVIADO' => 'EXTRAVIADO',
                                'DANADO' => 'DAÑADO',
                            ]),
                    ])
                    ->columns(2)
                    ->minItems(1)
                    ->defaultItems(0)
                    ->collapsible()
                    ->collapsed()
                    ->addActionLabel('Agregar Activo')
                    //->itemLabel(fn($state) => $state['material_id'] ? "Activo: {$state['material_id']}" : 'Nuevo Activo')
                    ->itemLabel(fn($record) => $record->material ? "Activo: {$record->material->nombre}" : 'Nuevo Activo'),
            ]);
    }
}
