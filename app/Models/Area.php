<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';

    protected $fillable = ['nombre'];

    public function empleados()
    {
        return $this->hasMany(Empleado::class);
    }

    protected static function booted()
    {
        static::creating(function ($area) {
            $area->nombre = preg_replace('/\s+/', ' ', trim($area->nombre));
        });

        static::updating(function ($area) {
            $area->nombre = preg_replace('/\s+/', ' ', trim($area->nombre));
        });
    }

    //Accesor
    public function getNombreAttribute($value){
        return ucwords(strtolower($value));
    }
}
