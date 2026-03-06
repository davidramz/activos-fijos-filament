<?php

namespace App\Filament\Resources\Puestos\Pages;

use App\Filament\Resources\Puestos\PuestoResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPuesto extends ViewRecord
{
    protected static string $resource = PuestoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
