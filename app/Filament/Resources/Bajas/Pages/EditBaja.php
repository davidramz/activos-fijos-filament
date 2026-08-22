<?php

namespace App\Filament\Resources\Bajas\Pages;

use App\Filament\Resources\Bajas\BajaResource;
use App\Models\ActivoMovimiento;
use App\Models\MovimientoTipo;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBaja extends EditRecord
{
    protected static string $resource = BajaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()
                ->before(function(DeleteAction $action) {
                    $Baja = $this->record;
                    
                    // Obtener o crear el tipo de movimiento "Devolución"
                    $movimientoDevolución = MovimientoTipo::firstOrCreate(
                        ['nombre' => 'Devolución'],
                        ['disponible' => true]
                    );

                    // Registrar movimientos de devolución para todos los activos
                    $activos = $Baja->activos()->get();
                    foreach ($activos as $activo) {
                        ActivoMovimiento::create([
                            'activo_id' => $activo->id,
                            'empleado_id' => $Baja->empleado_id,
                            'user_id' => auth()->id(),
                            'activo_status_id' => 1,
                            'movimiento_tipo_id' => $movimientoDevolución->id,
                            'observaciones' => "Devolución por eliminación de Baja #{$Baja->folio_formateado}",
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
        $Baja = $this->record;

        // Obtener o crear los tipos de movimiento
        $movimientoBaja = MovimientoTipo::firstOrCreate(
            ['nombre' => 'Baja'],
            ['disponible' => true]
        );
        
        $movimientoDevolución = MovimientoTipo::firstOrCreate(
            ['nombre' => 'Devolución'],
            ['disponible' => true]
        );

        // Obtener los activos previamente asignados
        $activosActuales = $Baja->activos()->pluck('activos.id')->toArray();

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
                    'empleado_id' => $Baja->empleado_id,
                    'user_id' => auth()->id(),
                    'activo_status_id' => 1,
                    'movimiento_tipo_id' => $movimientoDevolución->id,
                    'observaciones' => "Devolución - {$Baja->observaciones}",
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
                        'empleado_actual_id' => $Baja->empleado_id,
                    ]);

                    // Registrar movimiento de Baja
                    ActivoMovimiento::create([
                        'activo_id' => $activo->id,
                        'empleado_id' => $Baja->empleado_id,
                        'user_id' => auth()->id(),
                        'activo_status_id' => 2,
                        'movimiento_tipo_id' => $movimientoBaja->id,
                        'observaciones' => $Baja->observaciones,
                    ]);
                }
            }
        }

        // Activos que se mantienen pero cambió el empleado
        $activos = $Baja->activos()->get();
        foreach ($activos as $activo) {
            if ($activo->status_id !== 2 || $activo->empleado_actual_id !== $Baja->empleado_id) {
                $empleadoAnterior = $activo->empleado_actual_id;
                
                $activo->update([
                    'status_id' => 2,
                    'empleado_actual_id' => $Baja->empleado_id,
                ]);

                // Registrar movimiento de reasignación
                ActivoMovimiento::create([
                    'activo_id' => $activo->id,
                    'empleado_id' => $Baja->empleado_id,
                    'user_id' => auth()->id(),
                    'activo_status_id' => 2,
                    'movimiento_tipo_id' => $movimientoBaja->id,
                    'observaciones' => "Reasignación - {$Baja->observaciones}",
                ]);
            }
        }
    }
}
