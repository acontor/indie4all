<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class JuegosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('juegos')->insert([
            'nombre' => 'Mi amigo pedro',
            'contenido' => '',
            'sinopsis' => 'Es un juego de matar mucho',
            'fecha_lanzamiento' => '2020-10-20',
            'precio' =>43.44,
            'desarrolladora_id' => 1,
            'genero_id' => 1,
        ]);
        DB::table('juegos')->insert([
            'nombre' => 'Residente demoníaco 2',
            'sinopsis' => 'Juego que da mucho miedo',
            'fecha_lanzamiento' => '2020-11-05',
            'precio' => 49.99,
            'desarrolladora_id' => 1,
            'genero_id' => 7,
        ]);
        DB::table('juegos')->insert([
            'nombre' => 'Caballero hueco',
            'sinopsis' => 'Cuidao que te pierdes por el mapa',
            'fecha_lanzamiento' => '2020-05-05',
            'precio' =>19.99,
            'desarrolladora_id' => 1,
            'genero_id' => 2,
        ]);
        DB::table('juegos')->insert([
            'nombre' => 'Fuerza del horizonte 4',
            'sinopsis' => 'Juego para que vayas a toda velocidad',
            'fecha_lanzamiento' => '2020-12-05',
            'precio' =>59.99,
            'desarrolladora_id' => 2,
            'genero_id' => 3,
        ]);
        DB::table('juegos')->insert([
            'nombre' => 'Contraataque: Ofensiva Global',
            'sinopsis' => 'Juego de disparos por equipos',
            'fecha_lanzamiento' => '2018-11-05',
            'precio' =>5.99,
            'desarrolladora_id' => 2,
            'genero_id' => 8,
        ]);
        DB::table('juegos')->insert([
            'nombre' => 'Geraldo el magias 3',
            'sinopsis' => 'Siéntete un aventurero de verdad',
            'fecha_lanzamiento' => '2019-11-05',
            'precio' =>59.99,
            'desarrolladora_id' => 2,
            'genero_id' => 2,
        ]);
    }
}
