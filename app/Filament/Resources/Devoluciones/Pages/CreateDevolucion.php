<?php

namespace App\Filament\Resources\Devoluciones\Pages;

use App\Filament\Resources\Devoluciones\DevolucionesResource;
use App\Models\ActivoMovimiento;
use App\Models\MovimientoTipo;
use Filament\Resources\Pages\CreateRecord;

class CreateDevolucion extends CreateRecord
{
    protected static string $resource = DevolucionesResource::class;

    public function canCreateAnother(): bool
    {
        return false;
    }

    protected function afterCreate(): void
    {
        $resguardo = $this->record;
        $activos = $resguardo->activos()->get();

        // Obtener o crear el tipo de movimiento "Resguardo"
        $movimientoTipo = MovimientoTipo::firstOrCreate(
            ['nombre' => 'devolucion'],
            ['disponible' => true]
        );

        foreach ($activos as $activo) {
            // Actualizar el status y empleado_id del activo
            $activo->update([
                // status_id = 1 (Almacen), empleado_actual_id = NULL
                'status_id' => 1,
                'empleado_actual_id' => NULL,
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
                'empleado_origen_id' => $resguardo->empleado_id,
                'empleado_destino_id' => NULL,
                // status_antes_id = 2 (Resguardado), status_despues_id = 1 (Almacen)
                'status_antes_id' => 2,
                'status_despues_id' => 1,
                'tipo_id' => $movimientoTipo->id,
                'notas' => $resguardo->observaciones,
            ]);
        }
    }
    
}
