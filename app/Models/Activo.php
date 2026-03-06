<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activo extends Model
{
    protected $table = 'activos';

    protected $fillable = [
        'material_id', 'entrada_id', 'detalles',
        'costo', 'numero_inventario', 'numero_serie',
        'garantia', 'status', 'current_empleado_id',
    ];

    protected $casts = [
        'garantia' => 'datetime',
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
        return $this->belongsTo(Empleado::class, 'current_empleado_id');
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
}
