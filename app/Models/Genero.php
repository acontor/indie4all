<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    /**
     * Relationships
     */

    // Generos - 1:N - Juegos
    public function juegos()
    {
        return $this->hasMany("App\Models\Juego");
    }

    // Users - N:M - Generos
    public function usuarios()
    {
        return $this->belongsToMany("App\Models\User");
    }
}
