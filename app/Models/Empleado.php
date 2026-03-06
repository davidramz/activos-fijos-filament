<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';

    protected $fillable = [
        'area_id', 'puesto_id', 'campus_id',
        'numero', 'nombre',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function puesto()
    {
        return $this->belongsTo(Puesto::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function activosActuales()
    {
        return $this->hasMany(Activo::class, 'current_empleado_id');
    }

    public function movimientos()
    {
        return $this->hasMany(ActivoMovimiento::class);
    }
}
