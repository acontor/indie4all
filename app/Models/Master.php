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

    /**
     * Relationships
     */

    // Fans - N:M - Masters
    public function usuario()
    {
        return $this->belongsToMany("App\Models\User");
    }

    // Masters - 1:N - Posts
    public function posts()
    {
        return $this->hasMany("App\Models\Post");
    }
}
