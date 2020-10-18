<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'imagen_portada',
        'imagen_caratula',
        'sinopsis',
        'fecha_lanzamiento',
        'precio',
        'desarrolladora_id',
    ];

    /**
     * Relationships
     */

    // Desarrolladoras - 1:N - Juegos
    public function desarrolladora()
    {
        return $this->belongsTo("App\Models\Desarrolladora");
    }

    // Genero - 1:N - Juegos
    public function genero()
    {
        return $this->belongsTo("App\Models\Genero");
    }

    // Campañas - 1:N - Juegos
    public function campania()
    {
        return $this->hasOne("App\Models\Campania");
    }
}
