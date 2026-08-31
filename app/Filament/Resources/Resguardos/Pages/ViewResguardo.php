<?php

namespace App\Filament\Resources\Resguardos\Pages;

use App\Filament\Resources\Resguardos\ResguardoResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;
use Filament\Actions\EditAction;

class ViewResguardo extends ViewRecord
{
    protected static string $resource = ResguardoResource::class;

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
