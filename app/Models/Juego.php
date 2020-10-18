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
    public function desarrolladora()
    {
        return $this->belongsTo("App\Models\Desarrolladora");
    }
}
