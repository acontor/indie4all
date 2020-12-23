<?php

namespace App\Models;

use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'last_activity',
        'reportes',
        'ban',
        'motivo',
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

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));

    }

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

    // Users - 1:N - Compras
    public function compras()
    {
        return $this->hasMany("App\Models\Compra");
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

    // Usuario - 1:1 - Solicitud
    public function solicitud()
    {
        return $this->hasOne('\App\Models\Solicitud');
    }

    // Usuario - 1:N - Master
    public function master()
    {
        return $this->belongsTo("App\Models\Master", 'id', 'user_id');
    }

    // Usuario - 1:N - Masters
    public function cm()
    {
        return $this->belongsTo("App\Models\Cm", 'id', 'user_id');
    }

    // Usuario - 1:N - Masters
    public function administrador()
    {
        return $this->belongsTo("App\Models\Administrador", 'id', 'user_id');
    }

    // Usuario - N:N - Encuestas
    public function encuestas()
    {
        return $this->belongsToMany("App\Models\Encuesta")->withPivot('opcion_id');
    }
}
