<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Solicitud extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'tipo',
        'email',
        'direccion',
        'telefono',
        'url',
        'user_id',
    ];

    /**
     * Relationships
     */

    // Usuario - 1:1 - Solicitud
    public function usuario()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
