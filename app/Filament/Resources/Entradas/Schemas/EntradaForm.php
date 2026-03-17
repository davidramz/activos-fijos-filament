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
                    ->relationship('proveedor', 'nombre')
                    ->searchable(['nombre', 'codigo', 'rfc'])
                    ->columnSpan(2),

                TextInput::make('folio')
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('requisicion'),

                Select::make('tipo_compra')
                    ->options([
                        'directa' => 'directa',
                        'licitación' => 'licitación',
                        'consolidada' => 'consolidada',
                        'donación' => 'donación',
                        'promoción' => 'promoción',
                        'otra' => 'otra',
                    ]),

                DatePicker::make('fecha_factura')
                    ->label('Fecha de Factura'),

                Repeater::make('activos')
                    ->label('Activos')
                    ->relationship('activos')
                    ->columnSpanFull()
                    ->schema([
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
                            //->preserveFilenames()
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
                    ->addActionLabel('Agregar Activo'),
            ]);
    }
}
