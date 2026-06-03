<?php

namespace App\Filament\Resources\Resguardos\Pages;

use App\Filament\Resources\Resguardos\ResguardoResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditResguardo extends EditRecord
{
    protected static string $resource = ResguardoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $resguardo = $this->record;

        // Obtener los activos previamente asignados
        $activosActuales = $resguardo->activos()->pluck('activos.id')->toArray();

        // Obtener los activos que se acaban de asignar en el formulario
        $activosNuevos = $this->data['activos'] ?? [];

        // Activos que fueron desasignados (actualizar su status a 1 = ALMACEN)
        $activosADesasignar = array_diff($activosActuales, $activosNuevos);
        if (!empty($activosADesasignar)) {
            \App\Models\Activo::whereIn('id', $activosADesasignar)->update([
                'status_id' => 1,
                'empleado_actual_id' => null,
            ]);
        }

        // Activos que se mantienen o se acaban de asignar
        $activos = $resguardo->activos()->get();
        foreach ($activos as $activo) {
            if ($activo->status_id !== 2 || $activo->empleado_actual_id !== $resguardo->empleado_id) {
                $activo->update([
                    'status_id' => 2,
                    'empleado_actual_id' => $resguardo->empleado_id,
                ]);
            }
        }
    }
}
