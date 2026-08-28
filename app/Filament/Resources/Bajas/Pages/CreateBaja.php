<?php

namespace App\Filament\Resources\Bajas\Pages;

use App\Filament\Resources\Bajas\BajaResource;
use App\Models\ActivoMovimiento;
use App\Models\MovimientoTipo;
use Filament\Resources\Pages\CreateRecord;

class CreateBaja extends CreateRecord
{
    protected static string $resource = BajaResource::class;

    public function canCreateAnother(): bool
    {
        return false;
    }
    

    protected function afterCreate(): void
    {
        $Baja = $this->record;
        $activos = $Baja->activos()->get();

        // Obtener o crear el tipo de movimiento "Baja"
        $movimientoTipo = MovimientoTipo::firstOrCreate(
            ['nombre' => 'baja'],
            ['disponible' => true]
        );
            /* Actualizar el status_id = 3 (Baja) y empleado_id del activo
            
             * table:activo_status
             * status_antes_id,status_despues_id: 
             * 1 = Almacen, 
             * 2 = resguardado, 
             * 3 = Baja
             * 4 = Dev. proveedor
             * 5 = Suceptible
             * 6 = Cancelado
             * 7 = Reparacion
             * *-------------------------------------*/
        foreach ($activos as $activo) {
            
            $activo->update([
                'status_id' => 3,
                'empleado_actual_id' => NULL,
            ]);

            // Registrar el movimiento
            /**
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
                'empleado_origen_id' => $Baja->empleado_id,
                'empleado_destino_id' => NULL,
                'status_antes_id' => $activo->status_id,
                'status_despues_id' => 3,
                'tipo_id' => $movimientoTipo->id,
                'notas' => $Baja->detalles,
            ]);
        }
    }
    
}
