<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoCompra extends Model
{
    protected $table = 'tipo_compras';
    protected $fillable = ['nombre','disponible'];

    protected static function booted()
    {
        static::addGlobalScope('ordered', function ($query) {
            $query->orderBy('id', 'asc');
        });
    }

    public function entradas()
    {
        return $this->hasMany(Entrada::class);
    }
}
