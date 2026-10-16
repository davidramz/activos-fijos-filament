<?php

namespace App\Filament\Resources\Entradas\RelationManagers;

use App\Models\Activo;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\ImageEntry;
//use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Infolists\Components\ViewEntry;
//use Filament\Actions\BulkAction;

class ActivosRelationManager extends RelationManager
{
    protected static string $relationship = 'activos';

    protected static ?string $recordTitleAttribute = 'numero_inventario';

    public static function getTitle(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): string
    {
        return 'Activos';
    }
    /* Elimina el titulo de la Tabla de Activos Relacionados, sino aparecería arriba del buscador */
    protected function getTableHeading(): ?string
    {
        return '';
    }

    public function table(Table $table): Table
    {
        return $table
            //->headerActions([
                // CreateAction::make()
                //     ->schema([
                //         Select::make('material_id')
                //             ->label('Material')
                //             ->required()
                //             ->relationship('material', 'nombre')
                //             ->searchable(['nombre', 'codigo', 'marca'])
                //             ->getOptionLabelFromRecordUsing(fn($record) => "{$record->nombre} - {$record->marca} ({$record->modelo})")
                //             ->columnSpanFull(),

                //         TextInput::make('numero_serie')
                //             ->label('Número de Serie'),

                //         TextInput::make('costo')
                //             ->label('Costo')
                //             ->numeric()
                //             ->prefix('$'),

                //         DatePicker::make('garantia')
                //             ->label('Garantía'),

                //         Textarea::make('detalles')
                //             ->label('Detalles')
                //             ->columnSpanFull(),

                //         FileUpload::make('imagenes')
                //             ->label('Imágenes')
                //             ->multiple()
                //             ->reorderable()
                //             ->disk('public')
                //             ->directory('activos')
                //             ->visibility('public')
                //             ->image()
                //             ->maxSize(5120)
                //             ->columnSpanFull(),

                //         Select::make('status_id')
                //             ->label('Estadox')
                //             ->relationship('status', 'nombre')
                //             //->default(1), // Asumiendo que '1' es el ID del estado "En Almacén"
                //     ])
                //->columns(2),
            //])
            ->columns([
                TextColumn::make('numero_inventario')
                    ->label('Inventario')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('material.codigo')
                    ->label('Código'),

                TextColumn::make('material.nombre')
                    ->label('Material')
                    ->limit(50)
                    ->searchable(),

                TextColumn::make('material.marca')
                    ->label('Marca'),

                TextColumn::make('material.modelo')
                    ->label('Modelo'),

                TextColumn::make('numero_serie')
                    ->label('Serie')
                    ->searchable(),

                TextColumn::make('costo')
                    ->label('Costo')
                    ->money('MXN', locale: 'es_MX'),

                TextColumn::make('garantia')
                    ->label('Garantía')
                    ->dateTime('d/m/Y'),

                TextColumn::make('status.nombre')
                    ->label('Estado')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'ALMACEN' => 'almacen',
                        'RESGUARDADO' => 'success',
                        'BAJA' => 'baja',
                        'DEV.PROVEEDOR' => 'dev_proveedor',
                        'SUCEPTIBLE' => 'suceptible',
                        'CANCELADO' => 'danger',
                        'REPARACION' => 'warning',
                        default => 'gray',
                    }),

                // TextColumn::make('empleadoActual.nombre')
                //     ->label('Asignado a')
                //     ->searchable(),

                // TextColumn::make('detalles')
                //     ->label('Detalles')
                //     ->limit(50)
                //     ->tooltip(fn(Activo $record) => $record->detalles),

                // ImageColumn::make('imagenes')
                //     ->label('Imágenes')
                //     ->circular(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Ver')
                    ->infolist(function (Activo $record): array {
                        return [
                            ComponentsSection::make('Información del Activo')
                                ->columns(4)
                                ->schema([
                                    TextEntry::make('material.nombre')
                                        ->label('Material')
                                        ->columnSpanFull()
                                        ->state($record->material?->nombre),

                                    TextEntry::make('numero_inventario')
                                        ->label('Inventario')
                                        ->state($record->numero_inventario),

                                    TextEntry::make('numero_serie')
                                        ->label('Núm. Serie')
                                        ->state($record->numero_serie),

                                    

                                    TextEntry::make('material.marca')
                                        ->label('Marca')
                                        ->state($record->material?->marca),

                                    TextEntry::make('material.modelo')
                                        ->label('Modelo')
                                        ->state($record->material?->modelo),

                                    TextEntry::make('material.codigo')
                                        ->label('Código del Material')
                                        ->state($record->material?->codigo),

                                    TextEntry::make('costo')
                                        ->label('Costo')
                                        ->money('MXN', locale: 'es_MX')
                                        ->state($record->costo),

                                    TextEntry::make('garantia')
                                        ->label('Garantía')
                                        ->dateTime('d/m/Y')
                                        ->state($record->garantia),

                                    TextEntry::make('status.nombre')
                                        ->label('Estado')
                                        ->badge()
                                        ->color(fn(string $state): string => match ($state) {
                                            'ALMACEN' => 'almacen',
                                            'RESGUARDADO' => 'success',
                                            'BAJA' => 'baja',
                                            'DEV.PROVEEDOR' => 'dev_proveedor',
                                            'SUCEPTIBLE' => 'suceptible',
                                            'CANCELADO' => 'danger',
                                            'REPARACION' => 'warning',
                                            default => 'gray',
                                        })
                                        ->state($record->status->nombre),

                                    TextEntry::make('empleadoActual.nombre')
                                        ->label('Asignado a')                                        
                                        ->columnSpanFull()
                                        ->state($record->empleadoActual?->nombre),

                                    TextEntry::make('detalles')
                                        ->label('Detalles')
                                        ->columnSpanFull()
                                        ->state($record->detalles),

                                    // ImageEntry::make('imagenes')
                                    //     ->label('Imágenes')
                                    //     ->columnSpanFull(),
                                    ViewEntry::make('imagenes')
                                        ->label('Imágenes')
                                        ->columnSpanFull()
                                        ->view('filament.infolists.components.image-gallery', [
                                            // Images will be passed via the record
                                        ]),
                                ]),
                        ];
                    }),
                EditAction::make()
                    ->schema([
                        Select::make('material_id')
                            ->label('Material')
                            ->required()
                            ->relationship('material', 'nombre')
                            ->searchable(['nombre', 'codigo', 'marca'])
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->nombre} - {$record->marca} ({$record->modelo})")
                            ->columnSpanFull(),

                        TextInput::make('numero_inventario')
                            ->label('Inventario')
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
                            ->reorderable()
                            ->disk('public')
                            ->directory('activos')
                            ->visibility('public')
                            ->image()
                            ->maxSize(5120)
                            ->columnSpanFull(),

                        Select::make('status_id')
                            ->label('Estadow')
                            ->relationship('status', 'nombre')
                            ->default(1), // Asumiendo que '1' es el ID del estado
                    ]),
                DeleteAction::make(),
            ])
            ->emptyStateHeading('No hay activos')
            ->emptyStateDescription('Cree un activo para comenzar')
            ->emptyStateIcon('heroicon-o-rectangle-stack');
    }
}
