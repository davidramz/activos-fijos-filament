<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activo extends Model
{
    protected $table = 'activos';

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
    public function getCostoAttribute($value)
    {
        return number_format($value, 2, '.', ',');
    }
}
