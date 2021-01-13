<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Alvaro',
            'username' => 'Acontor',
            'email' => 'alvaro@mail.com',
            'password' => Hash::make('password'),
        ]);
        DB::table('administradors')->insert([
            'user_id' => 1,
        ]);
        DB::table('users')->insert([
            'name' => 'Justo',
            'username' => 'Jmedsol',
            'email' => 'justo@mail.com',
            'password' => Hash::make('password'),
        ]);
        DB::table('administradors')->insert([
            'user_id' => 2,
        ]);
        /* DB::table('users')->insert([
            'name' => 'pepe',
            'username' => 'pepito',
            'email' => 'pepe@mail.com',
            'password' => Hash::make('password'),
        ]);
        DB::table('masters')->insert([
            'nombre' => 'Pepón',
            'email' => 'master@email.com',
            'user_id' => 3,
        ]);
        DB::table('users')->insert([
            'name' => 'mengano',
            'username' => 'menganito',
            'email' => 'mengano@mail.com',
            'password' => Hash::make('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'jaime',
            'username' => 'jaimito',
            'email' => 'jaime@mail.com',
            'password' => Hash::make('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'soledad',
            'username' => 'solecito',
            'email' => 'soledad@mail.com',
            'password' => Hash::make('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'pablo',
            'username' => 'pablito',
            'email' => 'pablo@mail.com',
            'password' => Hash::make('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'miguel',
            'username' => 'miguelito',
            'email' => 'miguel@mail.com',
            'password' => Hash::make('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'ana',
            'username' => 'anita',
            'email' => 'ana@mail.com',
            'password' => Hash::make('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'paloma',
            'username' => 'palomita',
            'email' => 'paloma@mail.com',
            'password' => Hash::make('password'),
        ]); */
    }
}
