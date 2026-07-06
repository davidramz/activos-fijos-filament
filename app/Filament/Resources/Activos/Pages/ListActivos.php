<?php

namespace App\Filament\Resources\Activos\Pages;

use App\Filament\Resources\Activos\ActivosResource;
use Filament\Resources\Pages\ListRecords;

class ListActivos extends ListRecords
{
    protected static string $resource = ActivosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Sin botón de crear
        ];
    }
}
