<?php

namespace App\Filament\Resources\Bajas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;

class BajaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('empleado_id')
                    ->label('Empleado')
                    ->relationship('empleado', 'nombre')
                    ->searchable(['nombre', 'numero'])
                    ->required()
                    ->columnSpan(1),
                Hidden::make('user_id')
                    ->default(fn() => auth()->id()),
                Textarea::make('detalles')
                    ->label('Detalles de la Baja')
                    ->placeholder('Observaciones adicionales')
                    ->columnSpanFull(),
                Select::make('activos')
                    ->label('Activos a Dar de Baja')
                    ->relationship('activos', 'numero_inventario')
                    ->reorderable()
                    ->multiple()
                    ->getSearchResultsUsing(function(string $search): array {
                        return \App\Models\Activo::query()
                            ->where('status_id', 3)
                            ->with('material')
                            ->where(function($q) use ($search) {
                                $q->where('numero_inventario', 'like', "%{$search}%")
                                    ->orWhere('numero_serie', 'like', "%{$search}%")
                                    ->orWhereHas('material', fn($q) => $q->where('nombre', 'like', "%{$search}%"));
                            })
                            ->limit(20)
                            ->get()
                            ->mapWithKeys(fn($record) => [
                                $record->id => "{$record->numero_inventario} - {$record->material?->nombre} ({$record->numero_serie})"
                            ])
                            ->toArray();
                    })
                    ->getOptionLabelUsing(function($value) {
                        $record = \App\Models\Activo::with('material')->find($value);
                        return $record ? "{$record->numero_inventario} - {$record->material?->nombre} ({$record->numero_serie})" : $value;
                    })
                    ->required()
                    ->columnSpanFull()
                    ->helperText('Busca por número de inventario, serie o nombre del material')
                    ->optionsLimit(20),
            ]);
    }
}
