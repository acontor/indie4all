<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campania extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meta',
        'recaudado',
        'fecha_fin',
        'juego_id',
        'contenido',
        'ban',
        'motivo',
        'reportes',
        'faq',
    ];

    /**
     * Relationships
     */

    // Campanias - N:M - Users
    public function users()
    {
        return $this->belongsToMany("App\Models\Campania");
    }

    // Campanias - 1:1 - Juegos
    public function juego()
    {
        return $this->belongsTo('App\Models\Juego');
    }

    // Campaña - 1:N - Posts
    public function posts()
    {
        return $this->hasMany("App\Models\Post");
    }

    // Campaña - 1:N - Mensajes
    public function mensajes()
    {
        return $this->hasMany("App\Models\Mensaje");
    }
}
