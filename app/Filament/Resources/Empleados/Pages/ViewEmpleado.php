<?php

namespace App\Filament\Resources\Empleados\Pages;

use App\Filament\Resources\Empleados\EmpleadoResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;

class ViewEmpleado extends ViewRecord
{
    protected static string $resource = EmpleadoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Volver')
                ->alpineClickHandler('window.history.back()')
                ->icon('heroicon-o-arrow-left'),
            EditAction::make(),
        ];
    }
}
