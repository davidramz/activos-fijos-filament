<?php

namespace App\Filament\Resources\Unidads\Pages;

use App\Filament\Resources\Unidads\UnidadResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewUnidad extends ViewRecord
{
    protected static string $resource = UnidadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
