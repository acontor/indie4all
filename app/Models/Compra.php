<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'precio',
        'fecha_compra',
        'key',
        'campania_id',
        'juego_id',
        'user_id',
    ];

    /**
     * Relationships
     */

    // Campanias - 1:N - Compras
    public function campanias()
    {
        return $this->belongsTo("App\Models\Compra");
    }
}