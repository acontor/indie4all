<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SolicitudDesarrolladoraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('solicituds')->insert([
            'nombre' => 'Nueva desarrolladora',
            'tipo' => 'Desarrolladora',
            'email' => 'nuevadesarrolladora@mail.com',
            'direccion' => 'Direccion',
            'telefono' => 'Telefono',
            'url' => 'www.url.com',
            'user_id' => 6,
        ]);
        DB::table('solicituds')->insert([
            'nombre' => 'Nueva desarrolladora2',
            'tipo' => 'Desarrolladora',
            'email' => 'nuevadesarrolladora2@mail.com',
            'direccion' => 'Direccion2',
            'telefono' => 'Telefono2',
            'url' => 'www.url2.com',
            'user_id' => 7,
        ]);
    }
}
