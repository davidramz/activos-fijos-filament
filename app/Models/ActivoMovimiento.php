<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivoMovimiento extends Model
{
    protected $table = 'activo_movimientos';

    protected $fillable = [
        'activo_id', 'empleado_id', 'user_id',
        'tipo', 'observaciones',
    ];

    public function activo()
    {
        return $this->belongsTo(Activo::class);
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
