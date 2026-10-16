<?php

namespace App\Filament\Resources\Materiales\Pages;

use App\Filament\Resources\Materiales\MaterialResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMaterial extends ViewRecord
{
    protected static string $resource = MaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
    public function getTitle(): string
    {
        return 'Detalle del Material';
    }
}
