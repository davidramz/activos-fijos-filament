<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';

    protected $fillable = [
        'codigo', 'nombre', 'rfc', 'calle', 'colonia', 'cp',
        'ciudad', 'estado', 'telefono', 'giro',
    ];

    public function entradas()
    {
        return $this->hasMany(Entrada::class);
    }
    public function getNombreAttribute($value){
        return ucwords(strtolower($value));
    }
    public function getCalleAttribute($value){
        return ucfirst(strtolower($value));
    }
    public function getColoniaAttribute($value){
        return ucfirst(strtolower($value));
    }
    public function getCiudadAttribute($value){
        return ucfirst(strtolower($value));
    }
    public function getGiroAttribute($value){
        return ucfirst(strtolower($value));
    }
}
