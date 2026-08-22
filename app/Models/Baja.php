<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Baja extends Model
{
    protected $table = 'bajas';

    protected $fillable = [
        'folio',
        'anio',
        'empleado_id',
        'user_id',
        'detalles',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activos()
    {
        return $this->belongsToMany(
            Activo::class,
            'baja_activo'
        )->withTimestamps();
    }
    /*
    |--------------------------------------------------------------------------
    | GENERACIÓN AUTOMÁTICA DE FOLIO POR AÑO
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::creating(function ($resguardo) {

            $anioActual = now()->year;

            $ultimoFolio = self::where('anio', $anioActual)
                ->max('folio');

            $resguardo->anio = $anioActual;
            $resguardo->folio = $ultimoFolio ? $ultimoFolio + 1 : 1;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | FOLIO FORMATEADO
    |--------------------------------------------------------------------------
    */

    public function getFolioFormateadoAttribute()
    {
        return 'BAJ-' . $this->anio . '-' . str_pad($this->folio, 5, '0', STR_PAD_LEFT);
    }
}
