<?php

namespace App\Filament\Resources\Puestos\Pages;

use App\Filament\Resources\Puestos\PuestoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPuestos extends ListRecords
{
    protected static string $resource = PuestoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
