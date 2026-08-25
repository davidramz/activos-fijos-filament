<?php

namespace App\Filament\Resources\ResguardoEntreEmpleados\Pages;

use App\Filament\Resources\ResguardoEntreEmpleados\ResguardoEntreEmpleadosResource;
use App\Models\ActivoMovimiento;
use App\Models\MovimientoTipo;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditResguardoEntreEmpleados extends EditRecord
{
    protected static string $resource = ResguardoEntreEmpleadosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()
                ->before(function(DeleteAction $action) {
                    $resguardo = $this->record;
                    
                    // Obtener o crear el tipo de movimiento "Devolución"
                    $movimientoDevolución = MovimientoTipo::firstOrCreate(
                        ['nombre' => 'Devolución'],
                        ['disponible' => true]
                    );

                    // Registrar movimientos de devolución para todos los activos
                    $activos = $resguardo->activos()->get();
                    foreach ($activos as $activo) {
                        ActivoMovimiento::create([
                            'activo_id' => $activo->id,
                            'empleado_id' => $resguardo->empleado_id,
                            'user_id' => auth()->id(),
                            'activo_status_id' => 1,
                            'movimiento_tipo_id' => $movimientoDevolución->id,
                            'observaciones' => "Devolución por eliminación de resguardo #{$resguardo->folio_formateado}",
                        ]);

                        // Devolver el activo al almacén
                        $activo->update([
                            'status_id' => 1,
                            'empleado_actual_id' => null,
                        ]);
                    }
                }),
        ];
    }

    protected function afterSave(): void
    {
        $resguardo = $this->record;

        // Obtener o crear los tipos de movimiento
        $movimientoResguardo = MovimientoTipo::firstOrCreate(
            ['nombre' => 'Resguardo'],
            ['disponible' => true]
        );
        
        $movimientoDevolución = MovimientoTipo::firstOrCreate(
            ['nombre' => 'Devolución'],
            ['disponible' => true]
        );

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

            // Registrar movimientos de devolución
            foreach ($activosADesasignar as $activoId) {
                ActivoMovimiento::create([
                    'activo_id' => $activoId,
                    'empleado_id' => $resguardo->empleado_id,
                    'user_id' => auth()->id(),
                    'activo_status_id' => 1,
                    'movimiento_tipo_id' => $movimientoDevolución->id,
                    'observaciones' => "Devolución - {$resguardo->observaciones}",
                ]);
            }
        }

        // Activos nuevos que se acaban de asignar
        $activosNuevosAsignados = array_diff($activosNuevos, $activosActuales);
        if (!empty($activosNuevosAsignados)) {
            foreach ($activosNuevosAsignados as $activoId) {
                $activo = \App\Models\Activo::find($activoId);
                if ($activo) {
                    $activo->update([
                        'status_id' => 2,
                        'empleado_actual_id' => $resguardo->empleado_id,
                    ]);

                    // Registrar movimiento de resguardo
                    ActivoMovimiento::create([
                        'activo_id' => $activo->id,
                        'empleado_id' => $resguardo->empleado_id,
                        'user_id' => auth()->id(),
                        'activo_status_id' => 2,
                        'movimiento_tipo_id' => $movimientoResguardo->id,
                        'observaciones' => $resguardo->observaciones,
                    ]);
                }
            }
        }

        // Activos que se mantienen pero cambió el empleado
        $activos = $resguardo->activos()->get();
        foreach ($activos as $activo) {
            if ($activo->status_id !== 2 || $activo->empleado_actual_id !== $resguardo->empleado_id) {
                $empleadoAnterior = $activo->empleado_actual_id;
                
                $activo->update([
                    'status_id' => 2,
                    'empleado_actual_id' => $resguardo->empleado_id,
                ]);

                // Registrar movimiento de reasignación
                ActivoMovimiento::create([
                    'activo_id' => $activo->id,
                    'empleado_id' => $resguardo->empleado_id,
                    'user_id' => auth()->id(),
                    'activo_status_id' => 2,
                    'movimiento_tipo_id' => $movimientoResguardo->id,
                    'observaciones' => "Reasignación - {$resguardo->observaciones}",
                ]);
            }
        }
    }
}
