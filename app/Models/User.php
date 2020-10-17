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

    public function logros()
    {
        return $this->belongsToMany("App\Models\Logro");
    }

    public function generos()
    {
        return $this->belongsToMany("App\Models\Genero");
    }

    public function sorteos()
    {
        return $this->belongsToMany("App\Models\Sorteo");
    }

    public function desarrolladoras()
    {
        return $this->belongsToMany("App\Models\Desarrolladora")->withPivot('notificacion');
    }

    public function campania()
    {
        return $this->belongsToMany("App\Models\User")->withPivot('precio', 'fecha_pago');
    }
}
