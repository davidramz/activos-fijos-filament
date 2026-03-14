<?php

namespace App\Filament\Resources\Entradas\RelationManagers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ActivosRelationManager extends RelationManager
{
    protected static string $relationship = 'activos';

    protected static ?string $recordTitleAttribute = 'numero_inventario';

    public static function getTitle(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): string
    {
        return 'Activos';
    }

    protected function getTableHeadingActions(): array
    {
        return [
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
                ->columns(2),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('numero_inventario')
                    ->label('Inv.')
                    ->searchable(),

                TextColumn::make('material.nombre')
                    ->label('Material')
                    ->searchable(),

                TextColumn::make('material.marca')
                    ->label('Marca'),

                TextColumn::make('numero_serie')
                    ->label('Serie')
                    ->searchable(),

                TextColumn::make('costo')
                    ->label('Costo')
                    ->money('MXN'),

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

                TextColumn::make('garantia')
                    ->label('Garantía')
                    ->dateTime('d/m/Y'),

                ImageColumn::make('imagenes')
                    ->label('Imágenes')
                    ->circular(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
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
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->emptyStateHeading('No hay activos')
            ->emptyStateDescription('Cree un activo para comenzar')
            ->emptyStateIcon('heroicon-o-rectangle-stack');
    }
}
