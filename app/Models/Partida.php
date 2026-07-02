<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    protected $table = 'partidas';

    protected $fillable = ['codigo', 'tipo_id', 'nombre', 'detalle'];

    public function materiales()
    {
        return $this->hasMany(Material::class);
    }
    public function tipo()
    {
        return $this->belongsTo(PartidaTipo::class);
    }
    public function getDescripcionAttribute()
    {
        return "{$this->codigo} | {$this->nombre}";
    }
    //Accesor
    public function getNombreAttribute($value){
        return ucwords(strtolower($value));
    }
    //Accesor
    public function getDetalleAttribute($value){
        return ucfirst(strtolower($value));
    }
}
