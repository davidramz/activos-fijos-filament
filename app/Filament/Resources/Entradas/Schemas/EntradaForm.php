<?php

namespace App\Filament\Resources\Entradas\Schemas;

use App\Models\Activo;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use App\Models\Material;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;
use Filament\Schemas\Components\Grid;


class EntradaForm
{
    public static function configure(Schema $schema): Schema
    {
        $activoSchema = static fn (): array => [
            Select::make('material_id')
                ->label('Material')
                ->required()
                    ->validationMessages([
                        'required' => 'Se requiere un material.',
                    ])
                ->relationship('material', 'nombre')
                ->searchable(['nombre', 'codigo', 'marca'])                
                ->placeholder('Buscar un material')
                ->searchPrompt('Buscar por Código o Nombre')
                ->getOptionLabelFromRecordUsing(fn($record) => "{$record->codigo} - {$record->nombre} - {$record->marca} - {$record->modelo}")
                ->columnSpanFull()
                ->live(onBlur: true),

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
                ->inlineLabel()
                ->label('Detalles'),

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
                ->default(1),
        ];

        return $schema
            ->columns(4)
            ->components([
                Select::make('proveedor_id')
                    ->inlineLabel(false)
                    ->label('Proveedor')
                    ->placeholder('Buscar un proveedor')
                    ->searchPrompt('Buscar por Código o Nombre')
                    ->required()
                    ->validationMessages([
                        'required' => 'Se requiere un proveedor.',
                    ])
                    ->relationship('proveedor', 'nombre')
                    ->searchable(['nombre', 'codigo', 'rfc'])
                    ->columnSpanFull()
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

                TextInput::make('factura')
                    ->label('No. Factura')
                    ->required()
                    ->unique(
                        ignoreRecord: true,
                        modifyRuleUsing: fn (Unique $rule, Get $get) => $rule->where('fecha_factura', $get('fecha_factura')),
                    )
                    ->validationMessages([
                        'required' => 'Se requiere un folio.',
                        'unique' => 'Ya existe una entrada con esta factura en esa fecha.',
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
                    ->table([
                        TableColumn::make('Material')->markAsRequired(),
                        TableColumn::make('No. Serie'),
                        TableColumn::make('Costo'),
                        TableColumn::make('Garantía'),
                        // TableColumn::make('Detalles'),
                        // TableColumn::make('Imágenes'),
                    ])
                    ->compact()
                    ->schema($activoSchema())
                    ->columns(2)
                    ->minItems(1)
                    ->defaultItems(0)
                    ->collapsible()
                    ->collapsed()
                    ->addAction(fn (Action $action) => $action
                        ->model(Activo::class)
                        ->schema($activoSchema())
                        ->modalHeading('Agregar Activo a la Entrada')
                        ->modalSubmitActionLabel('Agregar Activo')
                        ->color('success')
                        ->action(function (array $data, Repeater $component, Action $action): void {
                            $items = $component->getRawState() ?? [];
                            $uuid = $component->generateUuid();

                            if ($uuid) {
                                $items[$uuid] = $data;
                            } else {
                                $items[] = $data;
                            }

                            $component->rawState($items);
                            //$component->collapsed(false, shouldMakeComponentCollapsible: false);
                            $component->callAfterStateUpdated();

                            if ($component->shouldPartiallyRenderAfterActionsCalled()) {
                                $component->partiallyRender();
                            }

                            $action->halt();
                        }))
                    ->addActionLabel('Agregar Activo')
            ]);
    }
}
