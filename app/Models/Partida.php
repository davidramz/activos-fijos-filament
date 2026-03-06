<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    protected $table = 'partidas';

    protected $fillable = ['codigo', 'tipo', 'nombre', 'detalle'];

    public function materiales()
    {
        return $this->hasMany(Material::class);
    }
}
