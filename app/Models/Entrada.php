<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    protected $table = 'entradas';

    protected $fillable = [
        'proveedor_id', 'user_id', 'folio',
        'requisicion', 'tipo_compra', 'fecha_factura',
    ];

    protected $casts = [
        'fecha_factura' => 'date',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activos()
    {
        return $this->hasMany(Activo::class);
    }
}
