<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoTipo extends Model
{
    protected $table = 'movimiento_tipos';
    protected $fillable = ['nombre','disponible'];

    public function movimientos()
    {
        return $this->hasMany(ActivoMovimiento::class);
    }
}
