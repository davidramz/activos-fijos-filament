<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    protected $table = 'entradas';

    protected static function booted(): void
    {
        static::created(function (Entrada $entrada): void {
            $entrada->forceFill([
                'consecutivo' => sprintf('A%05d', $entrada->getKey()),
            ])->saveQuietly();
        });
    }

    protected $fillable = [
        'proveedor_id', 'user_id', 'tipo_compra_id', 'factura','consecutivo',
        'requisicion', 'fecha_factura',
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
    
    public function tipoCompra()
    {
        return $this->belongsTo(TipoCompra::class);
    }
  
}
