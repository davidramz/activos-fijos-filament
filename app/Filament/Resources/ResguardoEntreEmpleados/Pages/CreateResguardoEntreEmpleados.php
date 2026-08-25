<?php

namespace App\Filament\Resources\ResguardoEntreEmpleados\Pages;

use App\Filament\Resources\ResguardoEntreEmpleados\ResguardoEntreEmpleadosResource;
use App\Models\ActivoMovimiento;
use App\Models\MovimientoTipo;
use Filament\Resources\Pages\CreateRecord;

class CreateResguardoEntreEmpleados extends CreateRecord
{
    protected static string $resource = ResguardoEntreEmpleadosResource::class;
    protected ?int $empleadoDestinoId = null;

    public function canCreateAnother(): bool
    {
        return false;
    }

    //Obtiene el valor del empleado_destino_id antes de crear el registro para usarlo después en afterCreate
    protected function beforeCreate(): void
    {
        $this->empleadoDestinoId = isset($this->data['empleado_destino_id'])
            ? (int) $this->data['empleado_destino_id']
            : null;
    }

    protected function afterCreate(): void
    {
        $resguardo = $this->record;
        $activos = $resguardo->activos()->get();

        // Obtener o crear el tipo de movimiento "Resguardo"
        $movimientoTipo = MovimientoTipo::firstOrCreate(
            ['nombre' => 'transferido'],
            ['disponible' => true]
        );
        // Actualizar el status y empleado_id del activo
            /**
             * table:activo_status
             * status_antes_id,status_despues_id: 
             * 1 = almacen, 
             * 2 = resguardado, 
             * 3 = Baja
             */
            
            // status_id = 2 (Resguardado), empleado_actual_id = NULL
        foreach ($activos as $activo) {            
            $activo->update([
                'status_id' => 2,
                'empleado_actual_id' => $this->empleadoDestinoId,
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
                'empleado_origen_id' => $resguardo->empleado_id,
                'empleado_destino_id' => $this->empleadoDestinoId,
                'status_antes_id' => 2,
                'status_despues_id' => 3,
                'tipo_id' => $movimientoTipo->id,
                'notas' => $resguardo->observaciones,
            ]);
        }
    }
    
}
