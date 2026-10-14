<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivoStatus extends Model
{
    protected $table = 'activo_status';
    protected $fillable = ['nombre','disponible'];

    public function activos()
    {
        return $this->hasMany(Activo::class);
    }
    public function movimientos()
    {
        return $this->hasMany(ActivoMovimiento::class);
    }
    // public function getNombreAttribute($value){
    //     return ucfirst(strtolower($value));
    // }
}
