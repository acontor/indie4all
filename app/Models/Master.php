<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'imagen',
        'user_id',
    ];

    public function fans()
    {
        return $this->belongsToMany("App\Models\Fan");
    }

    public function posts()
    {
        return $this->belongsToMany("App\Models\Juego")->withPivot('titulo', 'contenido', 'calificacion', 'fecha_publicacion');
    }
}
