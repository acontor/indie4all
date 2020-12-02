<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GenerosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('generos')->insert([
            'nombre' => 'Acción',
        ]);
        DB::table('generos')->insert([
            'nombre' => 'Aventuras',
        ]);
        DB::table('generos')->insert([
            'nombre' => 'Carreras',
        ]);
        DB::table('generos')->insert([
            'nombre' => 'Deportes',
        ]);
        DB::table('generos')->insert([
            'nombre' => 'Estrategia',
        ]);
        DB::table('generos')->insert([
            'nombre' => 'Rol',
        ]);
        DB::table('generos')->insert([
            'nombre' => 'Terror',
        ]);
        DB::table('generos')->insert([
            'nombre' => 'Shooter',
        ]);
        DB::table('generos')->insert([
            'nombre' => 'Simulación',
        ]);
    }
}
