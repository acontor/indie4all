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
            'nombre' => '2D Trassierra',
            'tipo' => 'Desarrolladora',
            'email' => '2dtrassierra@mail.com',
            'direccion' => 'Avenida Arroyo del Moro, s/n, 14011 Córdoba',
            'telefono' => '957 73 49 00',
            'url' => 'www.iestrassierra.com',
            'user_id' => 1,
        ]);
    }
}
