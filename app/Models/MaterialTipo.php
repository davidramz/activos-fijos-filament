<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialTipo extends Model
{
    protected $table = 'material_tipos';
    protected $fillable = ['nombre','disponible'];

    public function materiales()
    {
        return $this->hasMany(Material::class);
    }
}
