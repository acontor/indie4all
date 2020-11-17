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
            'name' => 'user1',
            'email' => 'user1@mail.com',
            'password' => Hash::make('password'),
        ]);
        DB::table('administradors')->insert([
            'user_id' => 1,
        ]);
        DB::table('users')->insert([
            'name' => 'user2',
            'email' => 'user2@mail.com',
            'password' => Hash::make('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'user3',
            'email' => 'user3@mail.com',
            'password' => Hash::make('password'),
        ]);
        DB::table('masters')->insert([
            'email' => 'email',
            'imagen' => '/imagen/master.png',
            'user_id' => 3,
        ]);
        DB::table('users')->insert([
            'name' => 'user4',
            'email' => 'user4@mail.com',
            'password' => Hash::make('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'user5',
            'email' => 'user5@mail.com',
            'password' => Hash::make('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'user6',
            'email' => 'user6@mail.com',
            'password' => Hash::make('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'user7',
            'email' => 'user7@mail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
