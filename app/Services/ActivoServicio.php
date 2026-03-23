<?php
namespace App\Services;

use App\Models\Activo;
use App\Models\ActivoMovimiento;
use Illuminate\Support\Facades\DB;

/**
 * Servicio para manejar la lógica de asignación, transferencia y devolución de activos.
 * Este servicio encapsula las operaciones relacionadas con los movimientos de activos, asegurando la integridad de los datos mediante transacciones.
 * Métodos:
 * - asignar: Asigna un activo a un empleado.
 * - reasignar: Transfiere un activo de un empleado a otro.
 * - devolverAlmacen: Devuelve un activo al almacén, desasignándolo de cualquier empleado.
 * - baja: Da de baja un activo, marcándolo como inactivo.
 * Cada método registra un movimiento en la tabla de movimientos de activos, permitiendo un historial completo de las acciones realizadas sobre cada activo.    
 * Tipos de movimiento recomendados 
 * ASIGNACION
 * REASIGNACION
 * DEVOLUCION
 * BAJA
 */
class ActivoService
{
    public function asignar(Activo $activo, int $empleadoId, int $userId, ?string $observaciones = null) {
        return DB::transaction(function () use ( $activo, $empleadoId, $userId, $observaciones) {
            // actualizar estado actual
            $activo->update([
                'current_empleado_id' => $empleadoId,
                'status' => 'RESGUARDADO',
            ]);

            // guardar movimiento
            ActivoMovimiento::create([
                'activo_id' => $activo->id,
                'empleado_id' => $empleadoId,
                'user_id' => $userId,
                'tipo' => 'ASIGNACION',
                'observaciones' => $observaciones,
            ]);

            return $activo;
        });
    }

    public function reasignar(
        Activo $activo,
        int $nuevoEmpleadoId,
        int $userId,
        ?string $observaciones = null
    ) {
        return DB::transaction(function () use (
            $activo, $nuevoEmpleadoId, $userId, $observaciones
        ) {

            $activo->update([
                'current_empleado_id' => $nuevoEmpleadoId,
            ]);

            ActivoMovimiento::create([
                'activo_id' => $activo->id,
                'empleado_id' => $nuevoEmpleadoId,
                'user_id' => $userId,
                'tipo' => 'REASIGNACION',
                'observaciones' => $observaciones,
            ]);

            return $activo;
        });
    }

    public function devolverAlmacen(
        Activo $activo,
        int $userId,
        ?string $observaciones = null
    ) {
        return DB::transaction(function () use ($activo, $userId, $observaciones) {

            $activo->update([
                'current_empleado_id' => null,
                'status' => 'ALMACEN',
            ]);

            ActivoMovimiento::create([
                'activo_id' => $activo->id,
                'empleado_id' => null,
                'user_id' => $userId,
                'tipo' => 'DEVOLUCION',
                'observaciones' => $observaciones,
            ]);

            return $activo;
        });
    }

    public function baja(
        Activo $activo,
        int $userId,
        string $motivo
    ) {
        return DB::transaction(function () use ($activo, $userId, $motivo) {

            $activo->update([
                'current_empleado_id' => null,
                'status' => 'BAJA',
            ]);

            ActivoMovimiento::create([
                'activo_id' => $activo->id,
                'empleado_id' => null,
                'user_id' => $userId,
                'tipo' => 'BAJA',
                'observaciones' => $motivo,
            ]);

            return $activo;
        });
    }
    // public function asignarActivo($activoId, $empleadoId, $observaciones = null)
    // {
    //     DB::transaction(function () use ($activoId, $empleadoId, $observaciones) {
    //         $activo = Activo::findOrFail($activoId);

    //         // Crear un nuevo movimiento de activo
    //         ActivoMovimiento::create([
    //             'activo_id' => $activo->id,
    //             'empleado_anterior_id' => null,
    //             'empleado_nuevo_id' => $empleadoId,
    //             'observaciones' => $observaciones,
    //         ]);

    //         // Actualizar el empleado asignado al activo
    //         $activo->empleado_id = $empleadoId;
    //         $activo->save();
    //     });
    // }

    // public function transferirActivo($activoId, $nuevoEmpleadoId, $observaciones = null)
    // {
    //     DB::transaction(function () use ($activoId, $nuevoEmpleadoId, $observaciones) {
    //         $activo = Activo::findOrFail($activoId);
    //         $empleadoAnteriorId = $activo->empleado_id;

    //         // Crear un nuevo movimiento de activo
    //         ActivoMovimiento::create([
    //             'activo_id' => $activo->id,
    //             'empleado_anterior_id' => $empleadoAnteriorId,
    //             'empleado_nuevo_id' => $nuevoEmpleadoId,
    //             'observaciones' => $observaciones,
    //         ]);

    //         // Actualizar el empleado asignado al activo
    //         $activo->empleado_id = $nuevoEmpleadoId;
    //         $activo->save();
    //     });
    // }
}