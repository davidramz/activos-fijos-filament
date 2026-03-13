<?php

namespace App\Filament\Resources\Entradas\Pages;

use App\Filament\Resources\Entradas\EntradaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditEntrada extends EditRecord
{
    protected static string $resource = EntradaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
