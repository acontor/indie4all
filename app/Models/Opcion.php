<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opcion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descripcion',
        'encuesta_id',
        'ganadora',
    ];
    public function encuesta()
    {
        return $this->belongsTo("App\Models\Encuesta");
    }
}
