<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'materiales';

    protected $fillable = [
        'partida_id', 'unidad_id', 'codigo',
        'nombre', 'marca', 'modelo', 'tipo_id',
    ];

    public function partida()
    {
        return $this->belongsTo(Partida::class);
    }

    public function unidad()
    {
        return $this->belongsTo(Unidad::class);
    }

    public function activos()
    {
        return $this->hasMany(Activo::class);
    }
    public function tipo()
    {
        return $this->belongsTo(MaterialTipo::class);
    }
    //Accesor
    // public function getNombreAttribute($value){
    //     return ucwords(strtolower($value));
    // }
    //Accesor
    // public function getMarcaAttribute($value){
    //     return ucwords(strtolower($value));
    // }
}
