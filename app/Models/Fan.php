<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
    ];

    /**
     * Relationships
     */

    // Fans - N:M - Masters
    public function masters()
    {
        return $this->belongsToMany("App\Models\Master")->withPivot('notificacion');
    }
}
