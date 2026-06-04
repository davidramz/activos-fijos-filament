<?php

namespace App\Filament\Resources\Resguardos\Pages;

use App\Filament\Resources\Resguardos\ResguardoResource;
use App\Models\ActivoMovimiento;
use App\Models\MovimientoTipo;
use Filament\Resources\Pages\CreateRecord;

class CreateResguardo extends CreateRecord
{
    protected static string $resource = ResguardoResource::class;

    protected function afterCreate(): void
    {
        $resguardo = $this->record;
        $activos = $resguardo->activos()->get();

        // Obtener o crear el tipo de movimiento "Resguardo"
        $movimientoTipo = MovimientoTipo::firstOrCreate(
            ['nombre' => 'asignado'],
            ['disponible' => true]
        );

        foreach ($activos as $activo) {
            // Actualizar el status y empleado_id del activo
            $activo->update([
                'status_id' => 2,
                'empleado_actual_id' => $resguardo->empleado_id,
            ]);

            // Registrar el movimiento
            /**
             * table:activo_status
             * status_antes_id,status_despues_id: 
             * 1 = almacen, 
             * 2 = resguardado, 
             * 3 = Baja
             * -------------------------------------
             * table: movimiento_tipos 
             * tipo_id:
             * 1 = creado, 
             * 2 = asignado, 
             * 3 = transferido, 
             * 4 = devolucion, 
             * 5 = baja
             */
            ActivoMovimiento::create([
                'activo_id' => $activo->id,
                'user_id' => auth()->id(),
                'empleado_origen_id' => NULL,
                'empleado_destino_id' => $resguardo->empleado_id,
                'status_antes_id' => 1,
                'status_despues_id' => 2,
                'tipo_id' => $movimientoTipo->id,
                'notas' => $resguardo->observaciones,
            ]);
        }
    }
    
}
