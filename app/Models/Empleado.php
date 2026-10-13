<?php

namespace App\Models;
//use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';

    protected $fillable = [
        'area_id', 
        'puesto_id', 
        'campus_id',
        'numero', 
        'nombre',
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
        return $this->hasMany(Activo::class, 'empleado_actual_id')
            ->join('materiales', 'activos.material_id', '=', 'materiales.id')
            ->select('activos.*')
            ->orderBy('materiales.nombre', 'asc');
    }


    public function movimientos()
    {
        return $this->hasMany(ActivoMovimiento::class);
    }
    
    //Accesor
    // public function getNombreAttribute($value){
    //     return ucwords(strtolower($value));
    // }

    public function getNumeroNombreAttribute($value){
        return $this->numero . ' - ' . $this->nombre;
    }

}
