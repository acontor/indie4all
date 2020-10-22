<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logro extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'icono',
    ];

    /**
     * Relationships
     */

    // Users - N:M - Logros
    public function usuarios()
    {
        return $this->belongsToMany("App\Models\User");
    }
}
