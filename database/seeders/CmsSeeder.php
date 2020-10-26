<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cms')->insert([
            'rol' => 'Jefe',
            'desarrolladora_id' => 1,
            'user_id' => 1,
        ]);
        DB::table('cms')->insert([
            'rol' => 'Jefe',
            'desarrolladora_id' => 2,
            'user_id' => 2,
        ]);
    }
}
