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
        'nombre',
        'email',
        'imagen_portada',
        'imagen_logo',
        'user_id',
    ];

    /**
     * Relationships
     */

    // Fans - N:M - Masters
    public function seguidores()
    {
        return $this->belongsToMany("App\Models\User")->withPivot('created_at');
    }

    // user - 1:M - Masters
    public function usuario()
    {
        return $this->belongsTo("App\Models\User", "user_id", "id");
    }

    // Masters - 1:N - Posts
    public function posts()
    {
        return $this->hasMany("App\Models\Post");
    }
}
