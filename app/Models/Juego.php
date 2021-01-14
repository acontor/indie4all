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
        'fecha_lanzamiento',
        'precio',
        'desarrolladora_id',
        'genero_id',
        'contenido',
        'ban',
        'motivo',
        'reportes',
    ];

    /**
     * Relationships
     */

    // Desarrolladoras - 1:N - Juegos
    public function desarrolladora()
    {
        return $this->belongsTo("App\Models\Desarrolladora", 'desarrolladora_id', 'id');
    }

    // Genero - 1:N - Juegos
    public function genero()
    {
        return $this->belongsTo("App\Models\Genero", 'genero_id', 'id');
    }

    // Campañas - 1:1 - Juegos
    public function campania()
    {
        return $this->hasOne("App\Models\Campania");
    }

    // Juegos - 1:N - Posts
    public function posts()
    {
        return $this->hasMany("App\Models\Post");
    }

    // Juegos - N:N - Usuarios
    public function seguidores()
    {
        return $this->belongsToMany("App\Models\User")->withPivot('calificacion');
    }

    // Claves - 1:N - Juegos
    public function claves()
    {
        return $this->hasMany("App\Models\Clave");
    }

    // Compras - 1:N - Juegos
    public function compras()
    {
        return $this->hasMany("App\Models\Compra");
    }
}
