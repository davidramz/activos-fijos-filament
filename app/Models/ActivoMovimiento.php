<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivoMovimiento extends Model
{
    protected $table = 'activo_movimientos';

    protected $fillable = [
        'activo_id', 
        'user_id', 
        'tipo_id', 
        'empleado_origen_id',
        'empleado_destino_id', 
        'status_antes_id',
        'status_despues_id',
        'notas',
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
    public function status()
    {
        return $this->belongsTo(ActivoStatus::class);
    }
    public function tipo()
    {
        return $this->belongsTo(MovimientoTipo::class);     
    }
}
