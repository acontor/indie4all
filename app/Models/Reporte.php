<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reporte extends Model
{
    use HasFactory, SoftDeletes;

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

    // Reporte - N:1 - Desarrolladora

    public function desarrolladora() {
        return $this->belongsTo("App\Models\Desarrolladora", "desarrolladora_id", "id");
    }

    // Reporte - N:1 - Post

    public function post() {
        return $this->belongsTo("App\Models\Post", "post_id", "id");
    }

    // Reporte - N:1 - Mensaje

    public function mensaje() {
        return $this->belongsTo("App\Models\Mensaje", "mensaje_id", "id");
    }

    // Reporte - N:1 - Juego

    public function juego() {
        return $this->belongsTo("App\Models\Juego", "juego_id", "id");
    }

    // Reporte - N:1 - Campaña

    public function campania() {
        return $this->belongsTo("App\Models\Campania", "campania_id", "id");
    }

    // Reporte - N:1 - Encuesta

    public function encuesta() {
        return $this->belongsTo("App\Models\Encuesta", "encuesta_id", "id");
    }

    // Reporte - N:1 - Sorteo

    public function sorteo() {
        return $this->belongsTo("App\Models\Sorteo", "sorteo_id", "id");
    }

    // Reporte - N:1 - Master

    public function master() {
        return $this->belongsTo("App\Models\Master", "master_id", "id");
    }

    // Reporte - N:1 - Desarrolladora

    public function usuario() {
        return $this->belongsTo("App\Models\User", "user_id", "id");
    }
}
