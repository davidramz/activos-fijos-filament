<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartidaTipo extends Model
{
    protected $table = 'partida_tipos';
    protected $fillable = ['nombre','disponible'];

    public function partidas()
    {
        return $this->hasMany(Partida::class);
    }
     //Accesor
    public function getNombreAttribute($value){
        return ucwords(strtolower($value));
    }
}
