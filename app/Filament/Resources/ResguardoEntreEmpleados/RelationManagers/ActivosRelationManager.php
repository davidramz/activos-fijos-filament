<?php

namespace App\Filament\Resources\ResguardoEntreEmpleados\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Section as ComponentsSection;
use App\Models\Activo;
use Filament\Infolists\Components\TextEntry;

class ActivosRelationManager extends RelationManager
{
    protected static string $relationship = 'activos';
    protected static ?string $recordTitleAttribute = 'numero_inventario';

    public static function getTitle(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): string
    {
        return 'Activos';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // TextInput::make('nombre')
                //     ->required()
                //     ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('numero_inventario')
                    ->label('Número Inventario')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('material.nombre')
                    ->label('Material')
                    ->searchable(),

                TextColumn::make('material.marca')
                    ->searchable()
                    ->label('Marca'),

                TextColumn::make('material.modelo')
                    ->searchable()
                    ->label('Modelo'),

                TextColumn::make('numero_serie')
                    ->label('Número de Serie')
                    ->searchable(),

                TextColumn::make('costo')
                    ->label('Costo')
                    ->alignRight()
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AttachAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DetachAction::make(),
                DeleteAction::make(),
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
                                        ->columnSpanFull()
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
                                        ->state($record->costo),

                                    TextEntry::make('garantia')
                                        ->label('Garantía')
                                        ->dateTime('d/m/Y')
                                        ->state($record->garantia),

                                    TextEntry::make('status.nombre')
                                        ->label('Estado')
                                        ->badge()
                                        ->color(fn(string $state): string => match ($state) {
                                            'Almacen' => 'almacen',
                                            'Resguardado' => 'success',
                                            'Baja' => 'baja',
                                            'Dev. proveedor' => 'dev_proveedor',
                                            'Suceptible' => 'suceptible',
                                            'Cancelado' => 'danger',
                                            'Reparacion' => 'warning',
                                            default => 'gray',
                                        })
                                        ->state($record->status->nombre),

                                    TextEntry::make('empleadoActual.nombre')
                                        ->label('Asignado a')
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
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
