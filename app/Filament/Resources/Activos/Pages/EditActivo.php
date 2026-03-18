<?php

namespace App\Filament\Resources\Activos\Pages;

use App\Filament\Resources\Activos\ActivosResource;
use App\Filament\Resources\Activos\Schemas\ActivoForm;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;

class EditActivo extends EditRecord
{
    protected static string $resource = ActivosResource::class;

    public function form(Schema $schema): Schema
    {
        return ActivoForm::configure($schema);
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->label('Ver'),
            DeleteAction::make()
                ->label('Eliminar'),
        ];
    }
}
