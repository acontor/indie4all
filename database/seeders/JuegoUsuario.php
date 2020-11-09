<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class JuegoUsuario extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('juego_user')->insert([
            'juego_id' => 1,
            'user_id' => 1,
            'notificacion' => 1,
            'calificacion' => 8,
        ]);
        DB::table('juego_user')->insert([
            'juego_id' => 2,
            'user_id' => 1,
            'notificacion' => 0,
            'calificacion' => 5,
        ]);
        DB::table('juego_user')->insert([
            'juego_id' => 1,
            'user_id' => 3,
            'notificacion' => 1,
            'calificacion' => 6,
        ]);
    }
}
