<?php

namespace App\Filament\Resources\Entradas\Schemas;

use App\Models\Activo;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Infolists\Components\TextEntry;
use App\Models\Material;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Support\RawJs;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Components\Checkbox;

class EntradaForm
{
    public static function configure(Schema $schema): Schema
    {
        $subtotal = static function (Get $get): float {
            return collect($get('activos') ?? [])
                ->sum(function (array $activo): float {
                    $costo = str_replace(',', '', (string) ($activo['costo'] ?? 0));

                    return is_numeric($costo) ? (float) $costo : 0;
                });
        };
        $ivaPorcentaje = (float) config('app.iva', 16);
        $ivaTasa = $ivaPorcentaje / 100;
        $isrPorcentaje = (float) config('app.isr', 1.25);
        $isrTasa = $isrPorcentaje / 100;
        $ivaImporte = static fn (Get $get): float => $get('iva') ? $subtotal($get) * $ivaTasa : 0;
        $isrImporte = static fn (Get $get): float => $get('isr') ? $subtotal($get) * $isrTasa : 0;

        $activoSchema = static fn (bool $hideLabels = false): array => [
            Select::make('material_id')
                ->label('Material')
                ->hiddenLabel($hideLabels)
                ->required()
                    ->validationMessages([
                        'required' => 'Se requiere un material.',
                    ])
                ->relationship('material', 'nombre')
                ->searchable(['nombre', 'codigo', 'marca'])                
                ->placeholder('Buscar un material')
                ->searchPrompt('Buscar por Código o Nombre')
                //->getOptionLabelFromRecordUsing(fn ($record) => "{$record->codigo} - {$record->nombre} - {$record->marca} - {$record->modelo}")
                ->columnSpanFull()
                ->live(onBlur: true),

            TextInput::make('numero_serie')
                ->inlineLabel(! $hideLabels)
                ->hiddenLabel($hideLabels)
                ->label('Número de Serie'),

            TextInput::make('costo')
                ->inlineLabel(! $hideLabels)
                ->required()
                ->hiddenLabel($hideLabels)
                ->mask(RawJs::make('$money($input, \'.\', \',\', 4)'))
                ->live(onBlur: true)
                ->dehydrateStateUsing(fn ($state) => is_string($state) ? str_replace(',', '', $state) : $state),
                // Parámetros: ($input, separador_decimal, separador_miles, cantidad_decimales),

            DatePicker::make('garantia')
                ->inlineLabel(! $hideLabels)
                ->hiddenLabel($hideLabels)
                ->label('Garantía'),

            Textarea::make('detalles')
                ->inlineLabel(! $hideLabels)
                ->hiddenLabel($hideLabels)
                ->label('Detalles'),

            FileUpload::make('imagenes')
                ->label('Imágenes')
                ->hiddenLabel($hideLabels)
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

        ];

        $activoTableSchema = $activoSchema(true);
        [$costoField] = array_splice($activoTableSchema, 2, 1);
        array_splice($activoTableSchema, 3, 0, [$costoField]);
        array_splice($activoTableSchema, 1, 0, [
            TextEntry::make('material_codigo')
                ->hiddenLabel()
                ->state(fn (Get $get): string => Material::find($get('material_id'))?->codigo ?? '—'),
            TextEntry::make('material_marca')
                ->hiddenLabel()
                ->state(fn (Get $get): string => Material::find($get('material_id'))?->marca ?? '—'),
            TextEntry::make('material_modelo')
                ->hiddenLabel()
                ->state(fn (Get $get): string => Material::find($get('material_id'))?->modelo ?? '—'),
        ]);

        return $schema
            ->columns(8)
            ->components([
                Select::make('proveedor_id')
                    ->columnSpan(6)
                    ->inlineLabel(false)
                    ->label('Proveedor')
                    ->placeholder('Buscar un proveedor')
                    ->searchPrompt('Buscar por Nombre o por RFC')
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->rfc} - {$record->nombre}")
                    ->required()
                    ->validationMessages([
                        'required' => 'Se requiere un proveedor.',
                    ])
                    ->relationship('proveedor', 'nombre')
                    ->searchable(['nombre', 'codigo', 'rfc'])
                    ->createOptionModalHeading('Nuevo Proveedor')
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

                Checkbox::make('iva')
                    ->label('Con IVA')
                    ->inline(false)
                    ->live()
                    ->default(true),
                Checkbox::make('isr')
                    ->label('Retener ISR')
                    ->inline(false)
                    ->live()
                    ->default(false),
                
                DatePicker::make('fecha_factura')
                ->columnSpan(2)
                    ->label('Fecha Factura')
                    ->required()
                    ->validationMessages([
                        'required' => 'Se requiere una fecha de factura.',
                    ]),

                TextInput::make('factura')
                    ->columnSpan(2)
                    ->label('No. Factura')
                    ->required()
                    ->unique(
                        ignoreRecord: true,
                        modifyRuleUsing: fn (Unique $rule, Get $get) => $rule->where('fecha_factura', $get('fecha_factura')),
                    )
                    ->validationMessages([
                        'required' => 'Se requiere un folio.',
                        'unique' => 'Ya existe una entrada con esta factura y fecha.',
                    ]),

                TextInput::make('requisicion')
                    ->columnSpan(2)
                    ->label('Requisición')
                    ->required()
                    ->validationMessages([
                        'required' => 'Se requiere una requisición.',
                    ]),

                Select::make('tipo_compra_id')
                ->columnSpan(2)
                    ->relationship('tipoCompra', 'nombre')
                    ->required()
                    ->validationMessages([
                        'required' => 'Seleccione una opción tipo de compra.',
                    ]) ->native(false)                    
                    ->createOptionModalHeading('Nuevo Tipo de Compra')
                    ->createOptionForm([
                        TextInput::make('nombre')
                            ->placeholder('Nombre de la tipo de compra')
                            ->required()
                            ->afterStateUpdated(function ($state, $set) {
                                $set('nombre', preg_replace('/\s+/', ' ', trim($state)));
                            })
                            ->unique(ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'Ya se encuentra registrada.',
                            ]),
                    ]),
                
                Repeater::make('activos')
                    ->inlineLabel(false)
                    ->hiddenLabel()
                    ->itemLabel(fn($state): string => is_array($state) && filled($state['material_id']) ? optional(Material::find($state['material_id']))->nombre : 'Seleccionar Activo')
                    ->required()
                    ->validationMessages([
                        'required' => 'Necesita agregar al menos un activo a la entrada.',
                    ])
                    ->relationship('activos')
                    ->mutateRelationshipDataBeforeCreateUsing(
                        fn (array $data): array => [
                            ...$data,
                            'status_id' => 3,
                        ],
                    )
                    ->deleteAction(fn (Action $action): Action => $action
                        ->requiresConfirmation()
                        ->modalHeading('¿Quitar activo de la entrada?')
                        ->modalDescription('El activo se quitará de esta entrada al guardar los cambios.')
                        ->modalSubmitActionLabel('Quitar activo')
                        ->modalCancelActionLabel('Cancelar'))
                    ->columnSpanFull()
                    ->table([
                        TableColumn::make('Material')->width('660px'),
                        TableColumn::make('Código')->width('160px'),
                        TableColumn::make('Marca')->width('160px'),
                        TableColumn::make('Modelo')->width('160px'),
                        TableColumn::make('No. Serie')->width('160px'),
                        TableColumn::make('Garantía')->width('150px'),
                        TableColumn::make('Costo')->width('120px'),
                        //TableColumn::make('Detalles'),
                        // TableColumn::make('Imágenes'),
                    ])
                    ->compact()
                    ->schema($activoTableSchema)
                    ->live()
                    ->extraAttributes(['class' => 'entrada-activos-repeater'])
                    //->live() hace la tabla reactiva, actualizando los datos en tiempo real sin necesidad de recargar la página.
                    //->extraAttributes(['class' => 'text-start'])
                    ->columns(2)
                    ->minItems(1)
                    ->defaultItems(0)
                    ->collapsible()
                    ->collapsed()
                    ->addAction(fn (Action $action) => $action
                        ->model(Activo::class)
                        ->schema($activoSchema())
                        ->modalHeading('Agregar Activo a la Entrada')
                        ->modalSubmitActionLabel('Agregar')
                        ->color('info')
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

                            Notification::make()
                                ->title('Activo agregado correctamente a la Entrada.')
                                ->success()
                                ->send();

                            $action->halt();
                        }))
                    ->addActionLabel('Agregar Activos a la Entrada'),

                Section::make('')
                    ->columnSpanFull()
                    //->columnSpan(8)
                    ->schema([
                        TextEntry::make('subtotal')
                            ->label('Subtotal')->inlineLabel()->alignment(Alignment::End)
                            ->state(fn (Get $get): string => '$ ' . number_format($subtotal($get), 4, '.', ','))
                            ->columnSpan(1)
                            ->columnStart(9),
                        TextEntry::make('iva_importe')
                            ->label('IVA ' . rtrim(rtrim(number_format($ivaPorcentaje, 2, '.', ''), '0'), '.') . ' %')->inlineLabel()->alignment(Alignment::End)
                            ->state(fn (Get $get): string => '$ ' . number_format($ivaImporte($get), 4, '.', ','))
                            ->columnSpan(1)
                            ->columnStart(9),
                        TextEntry::make('retencion_isr')
                            ->label('ISR ' . rtrim(rtrim(number_format($isrPorcentaje, 2, '.', ''), '0'), '.') . ' %')->inlineLabel()->alignment(Alignment::End)
                            ->state(fn (Get $get): string => '$ ' . number_format($isrImporte($get), 4, '.', ','))
                            ->columnSpan(1)
                            ->columnStart(9),
                        TextEntry::make('total')
                            ->label('Total')->inlineLabel()->alignment(Alignment::End)
                            ->state(fn (Get $get): string => '$ ' . number_format($subtotal($get) + $ivaImporte($get) - $isrImporte($get), 4, '.', ','))
                            ->columnSpan(1)
                            ->columnStart(9),
                    ]),
            ]);
    }
}
