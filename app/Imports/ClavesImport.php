<?php

namespace App\Imports;

use App\Models\Clave;
use Maatwebsite\Excel\Concerns\ToModel;

class ClavesImport implements ToModel
{

    public $juego;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($juego)
    {
        $this->juego = $juego;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Clave([
            'key' => $row[0],
            'juego_id' => $this->juego,
        ]);
    }
}
