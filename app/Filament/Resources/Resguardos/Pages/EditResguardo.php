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

        // Actualizar el status y empleado_id de los activos del resguardo
        $activos = $resguardo->activos()->get();

        foreach ($activos as $activo) {
            // Si el activo aún está en ALMACEN (no fue actualizado en creación),
            // actualizar su status a RESGUARDADO y asignar empleado
            if ($activo->status !== 'RESGUARDADO' || $activo->current_empleado_id !== $resguardo->empleado_id) {
                $activo->update([
                    'status' => 'RESGUARDADO',
                    'current_empleado_id' => $resguardo->empleado_id,
                ]);
            }
        }
    }
}
