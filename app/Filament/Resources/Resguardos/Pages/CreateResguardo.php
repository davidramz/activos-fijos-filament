<?php

namespace App\Filament\Resources\Resguardos\Pages;

use App\Filament\Resources\Resguardos\ResguardoResource;
use App\Models\Activo;
use Filament\Resources\Pages\CreateRecord;

class CreateResguardo extends CreateRecord
{
    protected static string $resource = ResguardoResource::class;

    protected function afterCreate(): void
    {
        $resguardo = $this->record;

        // Actualizar el status y empleado_id de los activos
        $activos = $resguardo->activos()->get();

        foreach ($activos as $activo) {
            $activo->update([
                'status_id' => 2,
                'current_empleado_id' => $resguardo->empleado_id,
            ]);
        }
    }
}
