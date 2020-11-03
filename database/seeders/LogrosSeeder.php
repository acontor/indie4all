<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LogrosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('logros')->insert([
            'nombre' => 'Gran mensajero',
            'descripcion' => 'Participa con muuuuuchos mensajes',
            'icono'=> '/logro/mensajes.png',
        ]);
        DB::table('logros')->insert([
            'nombre' => 'Logro 2',
            'descripcion' => 'Logro 2',
            'icono'=> '/logro/3.png',
        ]);
        DB::table('logros')->insert([
            'nombre' => 'Logro 3',
            'descripcion' => 'Logro 3',
            'icono'=> '/logro/3.png',
        ]);
        DB::table('logros')->insert([
            'nombre' => 'Logro 4',
            'descripcion' => 'Logro 4',
            'icono'=> '/logro/4.png',
        ]);
        DB::table('logros')->insert([
            'nombre' => 'Logro 5',
            'descripcion' => 'Logro 5',
            'icono'=> '/logro/5.png',
        ]);
        DB::table('logros')->insert([
            'nombre' => 'Logro 6',
            'descripcion' => 'Logro 6',
            'icono'=> '/logro/6.png',
        ]);
    }
}
