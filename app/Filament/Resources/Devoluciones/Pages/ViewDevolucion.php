<?php

namespace App\Filament\Resources\Devoluciones\Pages;

use App\Filament\Resources\Devoluciones\DevolucionesResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;
use Filament\Actions\EditAction;

class ViewDevolucion extends ViewRecord
{
    protected static string $resource = DevolucionesResource::class;

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
