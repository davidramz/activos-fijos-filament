<?php

namespace App\Filament\Resources\Entradas\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use App\Models\Material;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
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

                Select::make('tipo_compra_id')
                    ->relationship('tipoCompra', 'nombre')
                    ->required()
                    ->validationMessages([
                        'required' => 'Seleccione una opción tipo de compra.',
                    ]) ->native(false),

                DatePicker::make('fecha_factura')
                    ->label('Fecha de Factura')
                    ->required()
                    ->validationMessages([
                        'required' => 'Se requiere una fecha de factura.',
                    ]),

                Repeater::make('activos')
                    ->label('Activos')
                    ->itemLabel(fn($state): string => is_array($state) && filled($state['material_id']) ? optional(Material::find($state['material_id']))->nombre : 'Seleccionar Activo')
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

                        Select::make('status_id')
                            ->label('Estado')
                            ->relationship('status', 'nombre')
                            ->default('1') // Asumiendo que '1' es el ID del estado "En Almacén"
                            ->hidden()
                    ])
                    ->columns(2)
                    ->minItems(1)
                    ->defaultItems(0)
                    ->collapsible()
                    ->collapsed()
                    ->addActionLabel('Agregar Activo'),
            ]);
    }
}
