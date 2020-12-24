<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sorteo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_fin',
        'user_id',
        'desarrolladora_id',
    ];

    // Users - N:M - Sorteos
    public function participantes()
    {
        return $this->belongsToMany("App\Models\User")->withPivot('sorteo_id', 'user_id');
    }

    // Users - 1:N - Sorteos
    public function ganador()
    {
        return $this->belongsTo("App\Models\User", 'user_id', 'id');
    }

    // Users - 1:N - Sorteos
    public function desarrolladora()
    {
        return $this->belongsTo("App\Models\Desarrolladora");
    }
}
