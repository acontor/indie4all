<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pregunta',
        'fecha_fin',
        'desarrolladora_id',
    ];

    /**
     * Relationships
     */

    // Desarrolladoras - 1:N - Encuestas
    public function desarrolladora()
    {
        return $this->belongsTo("App\Models\Desarrolladora");
    }

    // Opciones - 1:N - Encuestas
    public function opciones()
    {
        return $this->hasMany('\App\Models\Opcion');
    }
}
