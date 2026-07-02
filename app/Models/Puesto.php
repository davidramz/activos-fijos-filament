<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    protected $table = 'puestos';

    protected $fillable = ['nombre'];

    public function empleados()
    {
        return $this->hasMany(Empleado::class);
    }
    //Accesor
    public function getNombreAttribute($value){
        return ucwords(strtolower($value));
    }
}
