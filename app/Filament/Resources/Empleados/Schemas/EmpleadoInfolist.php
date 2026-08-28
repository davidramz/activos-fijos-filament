<?php

namespace App\Filament\Resources\Empleados\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;
use Filament\Support\Enums\Alignment;

class EmpleadoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema        
            ->columns(1)
            ->components([
                Section::make('Información de Empleado')
                    ->columns(5)
                    ->compact()
                    ->schema([
                        TextEntry::make('numero')
                            ->label('No. Empleado'),
                        TextEntry::make('nombre')
                            ->label('Nombre'),
                        TextEntry::make('area.nombre')
                            ->label('Área'),
                        TextEntry::make('puesto.nombre')
                            ->label('Puesto'),
                        TextEntry::make('campus.nombre')
                            ->label('Campus')
                    ]),           
                Section::make('Activos Asignados')
                    ->compact()
                    ->schema([
                        RepeatableEntry::make('activosActuales')
                        ->hiddenLabel()
                            ->table([
                                TableColumn::make('No.Inventario'),
                                TableColumn::make('Material'),
                                TableColumn::make('Número de Serie'),
                                TableColumn::make('Marca'),
                                TableColumn::make('Modelo'),
                                TableColumn::make('Costo')
                                    ->alignment(Alignment::Center)
                                    ->width('150px'),
                            ])
                            ->schema([
                                TextEntry::make('numero_inventario'),
                                TextEntry::make('material.nombre'),
                                TextEntry::make('numero_serie'),
                                TextEntry::make('material.marca'),
                                TextEntry::make('material.modelo'),
                                TextEntry::make('costo')                         
                                    ->alignment(Alignment::End)
                            ])
                    ])
            ]);
    }
}
