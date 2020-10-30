<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titulo',
        'contenido',
        'calificacion',
        'desarrolladora_id',
        'juego_id',
        'master_id',
    ];

    /**
     * Relationships
     */

    // Masters - 1:N - Posts
    public function master()
    {
        return $this->belongsTo('App\Models\Master');
    }

    // Posts - 1:N - Mensajes
    public function mensajes()
    {
        return $this->hasMany("App\Models\Mensaje");
    }

    // Posts - 1:N - Desarrolladora
    public function desarrolladora()
    {
        return $this->belongsTo("App\Models\Desarrolladora");
    }

    // Posts - 1:N - Juegos
    public function juegos()
    {
        return $this->belongsTo("App\Models\Juego");
    }
}
