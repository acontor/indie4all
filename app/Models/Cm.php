<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cm extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'desarrolladora_id',
        'user_id',
    ];

    /**
     * Relationships
     */

    // Desarrolladoras - 1:N - CM
    public function desarrolladora()
    {
        return $this->belongsTo("App\Models\Desarrolladora");
    }
}
