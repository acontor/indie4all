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
    public function campania()
    {
        return $this->belongsTo("App\Models\Campania");
    }

    // Compra - 1:N - User
    public function participante()
    {
        return $this->belongsTo("App\Models\User", "user_id", "id");
    }
       // Compra - 1:N - Juego
    public function Juego()
    {
        return $this->belongsTo("App\Models\Juego",'juego_id' , 'id');
    }
}
