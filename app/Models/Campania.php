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
    ];

    /**
     * Relationships
     */

    // Campanias - N:M - Users
    public function users()
    {
        return $this->belongsToMany("App\Models\Campania");
    }

    // Campanias - N:M - Juegos
    public function juego()
    {
        return $this->belongsTo('App\Models\Juego');
    }
}
