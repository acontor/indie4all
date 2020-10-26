<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DesarrolladorasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('desarrolladoras')->insert([
<<<<<<< HEAD:database/seeders/DesarrolladorasSeeder.php
            'nombre' => '2D Trassierra',
            'email' => '2dtrassierra@mail.com',
            'direccion' => 'Avenida Arroyo del Moro, s/n, 14011 Córdoba',
            'telefono' => '957 73 49 00',
            'url' => 'www.iestrassierra.com',
            'imagen_logo' => '/trasierra.png'
        ]);
        DB::table('desarrolladoras')->insert([
            'nombre' => 'Turismo Studios',
            'email' => 'turismostudios@mail.com',
            'direccion' => 'Calle Gran Vía, 11, 28013 Madrid',
            'telefono' => '911 11 11 11',
            'url' => 'www.turismostudios.com',
            'imagen_logo' => '/turismostudios.png'
=======
            'id' => 1,
            'nombre' => 'Desarrolladora 1',
            'email' => Str::random(10) . '@gmail.com',
            'direccion'=> 'direccion desarrolladora 1',
            'telefono'=> 'telefono desarrolladora 1',
            'url' => 'url desarrolladora 1',
            'imagen_logo' => 'imagen_logo desarrolladora 1'         
>>>>>>> 52796baaeab21bc29cd2a87ac161ad3947079819:database/seeders/DesarrolladoraSeeder.php
        ]);
    }
}
