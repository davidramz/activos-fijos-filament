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
//use Filament\Actions\BulkAction;

class ActivosRelationManager extends RelationManager
{
    protected static string $relationship = 'activos';

    protected static ?string $recordTitleAttribute = 'numero_inventario';

    public static function getTitle(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): string
    {
        return 'Activos';
    }

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()
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
                            ->reorderable()
                            ->disk('public')
                            ->directory('activos')
                            ->visibility('public')
                            ->image()
                            ->maxSize(5120)
                            ->columnSpanFull(),

                        Select::make('status')
                            ->label('Estado')
                            ->options([
                                'Disponible' => 'Disponible',
                                'En uso' => 'En uso',
                                'Dañado' => 'Dañado',
                                'Fuera de servicio' => 'Fuera de servicio',
                            ]),
                    ])
                //->columns(2),
            ])
            ->columns([
                TextColumn::make('numero_inventario')
                    ->label('Número Inventario')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('material.nombre')
                    ->label('Material')
                    ->searchable(),

                TextColumn::make('material.marca')
                    ->label('Marca'),

                TextColumn::make('material.modelo')
                    ->label('Modelo'),

                TextColumn::make('numero_serie')
                    ->label('Número de Serie')
                    ->searchable(),

                TextColumn::make('costo')
                    ->label('Costo')
                    ->money('MXN'),

                TextColumn::make('garantia')
                    ->label('Garantía')
                    ->dateTime('d/m/Y'),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Disponible' => 'success',
                        'En uso' => 'info',
                        'Dañado' => 'danger',
                        'Fuera de servicio' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('empleadoActual.nombre')
                    ->label('Asignado a')
                    ->searchable(),

                TextColumn::make('detalles')
                    ->label('Detalles')
                    ->limit(50)
                    ->tooltip(fn(Activo $record) => $record->detalles),

                ImageColumn::make('imagenes')
                    ->label('Imágenes')
                    ->circular(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Ver')
                    ->icon('heroicon-o-eye')
                    ->infolist(function (Activo $record): array {
                        return [
                            ComponentsSection::make('Información del Activo')
                                ->columns(2)
                                ->schema([
                                    TextEntry::make('numero_inventario')
                                        ->label('Número de Inventario')
                                        ->state($record->numero_inventario),

                                    TextEntry::make('numero_serie')
                                        ->label('Número de Serie')
                                        ->state($record->numero_serie),

                                    TextEntry::make('material.nombre')
                                        ->label('Material')
                                        ->state($record->material?->nombre),

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
                                        ->money('MXN')
                                        ->state($record->costo),

                                    TextEntry::make('garantia')
                                        ->label('Garantía')
                                        ->dateTime('d/m/Y')
                                        ->state($record->garantia),

                                    TextEntry::make('status')
                                        ->label('Estado')
                                        ->badge()
                                        ->color(fn(string $state): string => match ($state) {
                                            'Disponible' => 'success',
                                            'En uso' => 'info',
                                            'Dañado' => 'danger',
                                            'Fuera de servicio' => 'warning',
                                            default => 'gray',
                                        })
                                        ->state($record->status),

                                    TextEntry::make('empleadoActual.nombre')
                                        ->label('Asignado a')
                                        ->state($record->empleadoActual?->nombre),

                                    TextEntry::make('detalles')
                                        ->label('Detalles')
                                        ->columnSpanFull()
                                        ->state($record->detalles),

                                    ImageEntry::make('imagenes')
                                        ->label('Imágenes')
                                        ->columnSpanFull(),
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
                            ->reorderable()
                            ->disk('public')
                            ->directory('activos')
                            ->visibility('public')
                            ->image()
                            ->maxSize(5120)
                            ->columnSpanFull(),

                        Select::make('status')
                            ->label('Estado')
                            ->options([
                                'Disponible' => 'Disponible',
                                'En uso' => 'En uso',
                                'Dañado' => 'Dañado',
                                'Fuera de servicio' => 'Fuera de servicio',
                            ]),
                    ]),
                DeleteAction::make(),
            ])
            ->emptyStateHeading('No hay activos')
            ->emptyStateDescription('Cree un activo para comenzar')
            ->emptyStateIcon('heroicon-o-rectangle-stack');
    }
}
