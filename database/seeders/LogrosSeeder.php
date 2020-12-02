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
            'nombre' => 'El mensajero',
            'descripcion' => '¡Has participado con muchos mensajes!',
            'icono'=> 'fas fa-sms',
        ]);
        DB::table('logros')->insert([
            'nombre' => 'El veterano',
            'descripcion' => '¡Wow, llevas 1 año en Indie4all!',
            'icono'=> 'far fa-calendar-check',
        ]);
        DB::table('logros')->insert([
            'nombre' => 'El comprador',
            'descripcion' => '¡Oye, veo que te gustan los juegos!',
            'icono'=> 'fas fa-piggy-bank',
        ]);
        DB::table('logros')->insert([
            'nombre' => 'El inversor',
            'descripcion' => '¡Se nota que te gusta aportar a la industria!',
            'icono'=> 'fas fa-bullhorn',
        ]);
        DB::table('logros')->insert([
            'nombre' => 'El seguidor',
            'descripcion' => '¡Así me gusta, hay que darle cariño a nuestros masters, desarrolladora y sus videojeugos!',
            'icono'=> 'far fa-heart',
        ]);
        DB::table('logros')->insert([
            'nombre' => 'El mejor',
            'descripcion' => 'Ahora si estoy impresionado, ¡has conseguido todos los logros!',
            'icono'=> 'fas fa-medal',
        ]);
    }
}
