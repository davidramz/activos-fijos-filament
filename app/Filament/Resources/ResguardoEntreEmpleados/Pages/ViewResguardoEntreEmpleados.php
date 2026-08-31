<?php

namespace App\Filament\Resources\ResguardoEntreEmpleados\Pages;

use App\Filament\Resources\ResguardoEntreEmpleados\ResguardoEntreEmpleadosResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;
use Filament\Actions\EditAction;

class ViewResguardoEntreEmpleados extends ViewRecord
{
    protected static string $resource = ResguardoEntreEmpleadosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Volver al listado')
                ->url(static::getResource()::getUrl('index'))
                ->icon('heroicon-o-arrow-left'),
            //EditAction::make(),
        ];
    }
}
