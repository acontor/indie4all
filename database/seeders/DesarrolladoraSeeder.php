<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DesarrolladoraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('desarrolladoras')->insert([
            'id' => 1,
            'nombre' => 'Desarrolladora 1',
            'email' => Str::random(10) . '@gmail.com',
            'direccion'=> 'direccion desarrolladora 1',
            'telefono'=> 'telefono desarrolladora 1',
            'url' => 'url desarrolladora 1',
            'imagen_logo' => 'imagen_logo desarrolladora 1'         
        ]);
    }
}
