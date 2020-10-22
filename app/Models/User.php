<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relationships
     */

    // Users - N:M - Logros
    public function logros()
    {
        return $this->belongsToMany("App\Models\Logro");
    }

    // Users - N:M - Generos
    public function generos()
    {
        return $this->belongsToMany("App\Models\Genero");
    }

    // Users - N:M - Sorteos
    public function sorteos()
    {
        return $this->belongsToMany("App\Models\Sorteo");
    }

    // Users - N:M - Desarrolladoras
    public function desarrolladoras()
    {
        return $this->belongsToMany("App\Models\Desarrolladora")->withPivot('notificacion');
    }

    // Users - N:M - Campañas
    public function campania()
    {
        return $this->belongsToMany("App\Models\User")->withPivot('precio', 'fecha_pago');
    }

    // Users - 1:N - Mensajes
    public function mensajes()
    {
        return $this->hasMany("App\Models\Mensaje");
    }

    // Usuario - N:M - Masters
    public function masters()
    {
        return $this->belongsToMany("App\Models\Master")->withPivot('notificacion');
    }

    // Usuario - N:M - Juego
    public function juegos()
    {
        return $this->belongsToMany("App\Models\Juego")->withPivot('notificacion', 'calificacion');
    }
}
