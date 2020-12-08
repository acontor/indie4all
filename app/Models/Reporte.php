<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'motivo',
        'campania_id',
        'encuesta_id',
        'desarrolladora_id',
        'juego_id',
        'master_id',
        'post_id',
        'sorteo_id',
        'mensaje_id',
    ];
}
