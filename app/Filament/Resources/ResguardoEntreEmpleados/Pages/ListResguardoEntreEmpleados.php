<?php

namespace App\Filament\Resources\ResguardoEntreEmpleados\Pages;

use App\Filament\Resources\ResguardoEntreEmpleados\ResguardoEntreEmpleadosResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListResguardoEntreEmpleados extends ListRecords
{
    protected static string $resource = ResguardoEntreEmpleadosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make('create')
                ->label('Crear Resguardo entre Empleados')
        ];
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->where('tipo_id', 3);
    }
}
