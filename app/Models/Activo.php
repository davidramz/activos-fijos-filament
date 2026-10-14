<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activo extends Model
{
    protected $table = 'activos';

    protected static function booted(): void
    {
        static::created(function (Activo $activo): void {
            $activo->forceFill([
                'numero_inventario' => sprintf('UNPA/INT/%05d', $activo->getKey()),
            ])->saveQuietly();
        });
    }

    protected $fillable = [
        'material_id', 
        'entrada_id',
        'status_id', 
        'detalles',
        'imagenes',
        'costo', 
        'numero_inventario', 
        'numero_serie',
        'garantia', 
        'empleado_actual_id',
    ];

    protected $casts = [
        'garantia' => 'datetime',
        'imagenes' => 'array',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function entrada()
    {
        return $this->belongsTo(Entrada::class);
    }

    public function empleadoActual()
    {
        return $this->belongsTo(Empleado::class, 'empleado_actual_id');
    }

    public function movimientos()
    {
        return $this->hasMany(ActivoMovimiento::class);
    }

    public function resguardos()
    {
        return $this->belongsToMany(
            Resguardo::class,
            'resguardo_activo'
        )->withTimestamps();
    }
    public function bajas()
    {
        return $this->belongsToMany(
            Baja::class,
            'baja_activo'
        )->withTimestamps();
    }
    public function status()
    {
        return $this->belongsTo(ActivoStatus::class, 'status_id');
    }
    // public function getCostoAttribute($value)
    // {
    //     return $this->formatearDinamico($value);
    // }
    private function formatearDinamico($numero) {
        //Elimina ceros a l derecha del número
        $numero = rtrim(rtrim($numero, '0'), '.');
        // Obtiene la parte decimal del número
        $partes = explode('.', (string)$numero);
        $cantDecimales = isset($partes[1]) ? strlen($partes[1]) : 0;

        // Limita los decimales a un mínimo de 2 y un máximo de 4
        $decimalesAEditar = max(2, min(4, $cantDecimales));

        // Retorna el número formateado (puedes cambiar "," y "." según tu región)
        return number_format($numero, $decimalesAEditar, '.', ',');
    }
}
