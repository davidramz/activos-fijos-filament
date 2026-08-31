<?php

namespace App\Filament\Resources\Bajas\Pages;

use App\Filament\Resources\Bajas\BajaResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;
use Filament\Actions\EditAction;

class ViewBaja extends ViewRecord
{
    protected static string $resource = BajaResource::class;

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
