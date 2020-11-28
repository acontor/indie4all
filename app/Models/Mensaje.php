<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contenido',
        'post_id',
        'analisis_id',
        'user_id',
    ];

    /**
     * Relationships
     */

    // Users - 1:N - Mensajes
    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }

    // Posts - 1:N - Mensajes
    public function post()
    {
        return $this->belongsTo("App\Models\Post");
    }
}
