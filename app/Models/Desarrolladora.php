<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Desarrolladora extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'email',
        'direccion',
        'telefono',
        'url',
        'imagen_portada',
        'imagen_logo',
        'contenido',
        'ban',
        'motivo',
        'reportes',
    ];

    /**
     * Relationships
     */

    // Desarrolladoras - N:M - Users
    public function seguidores()
    {
        return $this->belongsToMany("App\Models\User");
    }

    // Desarrolladoras - 1:N - Juegos
    public function juegos()
    {
        return $this->hasMany("App\Models\Juego");
    }

    // Desarrolladoras - 1:N - Encuestas
    public function encuestas()
    {
        return $this->hasMany("App\Models\Encuesta");
    }

    // Desarrolladoras - 1:N - Sorteos
    public function sorteos()
    {
        return $this->hasMany("App\Models\Sorteo")->orderBy('fecha_fin', 'DESC');
    }

    // Desarrolladoras - 1:N - Cms
    public function cms()
    {
        return $this->hasMany("App\Models\CM");
    }

    // Desarrolladoras - 1:N - Posts
    public function posts()
    {
        return $this->hasMany("App\Models\Post", "desarrolladora_id", "id");
    }
}
