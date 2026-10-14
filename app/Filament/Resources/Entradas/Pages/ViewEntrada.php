<?php

namespace App\Filament\Resources\Entradas\Pages;

use App\Filament\Resources\Entradas\EntradaResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\EditAction;

class ViewEntrada extends ViewRecord
{
    protected static string $resource = EntradaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
