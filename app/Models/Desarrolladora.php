<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desarrolladora extends Model
{
    use HasFactory;

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
        'imagen_logo',
    ];

    /**
     * Relationships
     */

    // Desarrolladoras - N:M - Users
    public function users()
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
        return $this->belongsTo("App\Models\Encuesta", "id", "desarrolladora_id");
    }

    // Desarrolladoras - 1:N - Sorteos
    public function sorteos()
    {
        return $this->belongsTo("App\Models\Sorteo", "id", "desarrolladora_id");
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
