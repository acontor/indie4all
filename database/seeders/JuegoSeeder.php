<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class JuegoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('juegos')->insert([
            'nombre' => 'Juego 2',
            'imagen_portada' => '/imagenportada',
            'imagen_caratula' => '/imagencaratula',
            'sinopsis' => 'sipnosis',
            'fecha_lanzamiento' => '2012-11-05',
            'precio' =>43.44,
            'desarrolladora_id' => 1,
        ]);
        DB::table('juegos')->insert([
            'nombre' => 'Juego 2',
            'imagen_portada' => '/imagenportada',
            'imagen_caratula' => '/imagencaratula',
            'sinopsis' => 'sipnosis',
            'fecha_lanzamiento' => '2015-11-05',
            'precio' =>43.44,
            'desarrolladora_id' => 2,
        ]);
    }
}
