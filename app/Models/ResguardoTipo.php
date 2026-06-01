<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResguardoTipo extends Model
{
    protected $table = 'resguardo_tipos';

    protected $fillable = ['nombre'];

    public function resguardos()
    {
        return $this->hasMany(Resguardo::class);
    }
}
