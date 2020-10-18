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

    public function users()
    {
        return $this->belongsToMany("App\Models\User");
    }
    public function juegos()
    {
        return $this->hasMany("App\Models\Juego");
    }
    public function encuesta()
    {
        return $this->belongsTo("App\Models\Encuesta");
    }
    public function sorteo()
    {
        return $this->belongsTo("App\Models\Sorteo");
    }
  
    
}
