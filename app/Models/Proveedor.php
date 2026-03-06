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
}
