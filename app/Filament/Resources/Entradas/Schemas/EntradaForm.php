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
use Filament\Schemas\Components\Grid;


class EntradaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->inlineLabel()
            ->components([
                Select::make('proveedor_id')
                    ->label('Proveedor')
                    ->required()
                    ->validationMessages([
                        'required' => 'Se requiere un proveedor.',
                    ])
                    ->relationship('proveedor', 'nombre')
                    ->searchable(['nombre', 'codigo', 'rfc'])
                    ->columnSpan(2)
                    ->createOptionForm([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('nombre')
                            ->placeholder('Nombre del proveedor')
                            ->required()
                            ->afterStateUpdated(function ($state, $set) {
                                $set('nombre', preg_replace('/\s+/', ' ', trim($state)));
                            })
                            ->unique(ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'Ya se encuentra registrado.',
                            ]),
                        TextInput::make('codigo')
                            ->placeholder('Código del proveedor')
                            ->required()
                            ->afterStateUpdated(function ($state, $set) {
                                $set('codigo', preg_replace('/\s+/', ' ', trim($state)));
                            })
                            ->unique(ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'Ya se encuentra registrado.',
                            ]),
                        TextInput::make('rfc')
                            ->placeholder('RFC del proveedor')
                            ->required()
                            ->afterStateUpdated(function ($state, $set) {
                                $set('rfc', preg_replace('/\s+/', ' ', trim($state)));
                            })
                            ->unique(ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'Ya se encuentra registrado.',
                            ])
                            ->maxLength(13),
                        TextInput::make('calle'),
                        TextInput::make('colonia'),
                        TextInput::make('cp'),
                        TextInput::make('ciudad'),
                        TextInput::make('estado'),
                        TextInput::make('telefono')
                            ->tel()
                            ->maxLength(10),
                        TextInput::make('giro'),
                            ])
                    ]),

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
                    ->inlineLabel(false)
                    ->hiddenLabel()
                    ->itemLabel(fn($state): string => is_array($state) && filled($state['material_id']) ? optional(Material::find($state['material_id']))->nombre : 'Seleccionar Activo')
                    ->required()
                    ->validationMessages([
                        'required' => 'Se requiere un activo.',
                    ])
                    ->relationship('activos')
                    ->columnSpanFull()
                    ->schema([
                        Select::make('material_id')                        
                            ->inlineLabel()
                            ->label('Material')
                            ->required()
                            ->relationship('material', 'nombre')
                            ->searchable(['nombre', 'codigo', 'marca'])
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->nombre} - {$record->marca} ({$record->modelo})")
                            ->columnSpanFull()
                            ->live(onBlur: true),

                        TextInput::make('numero_inventario')
                            ->inlineLabel()
                            ->columns(2)
                            ->label('Número de Inventario')
                            ->required(),

                        TextInput::make('numero_serie')
                            ->inlineLabel()
                            ->label('Número de Serie'),

                        TextInput::make('costo')
                            ->inlineLabel()
                            ->label('Costo')
                            ->numeric()
                            ->prefix('$'),

                        DatePicker::make('garantia')
                            ->inlineLabel()
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

                        Hidden::make('status_id')
                            //->label('Estado')
                            //->relationship('status', 'nombre')
                            ->default(1) // Asumiendo que '1' es el ID del estado "En Almacén"
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
