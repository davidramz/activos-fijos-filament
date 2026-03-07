<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resguardo extends Model
{
    use HasFactory;
    protected $table = 'resguardos';
    protected $fillable = [
        'folio',
        'anio',
        'empleado_id',
        'user_id',
        'observaciones',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

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
            'resguardo_activo'
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
        return 'RES-' . $this->anio . '-' . str_pad($this->folio, 5, '0', STR_PAD_LEFT);
    }
}
