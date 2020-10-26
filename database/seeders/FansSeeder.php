<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fans')->insert([
            'user_id' => 4,
        ]);
        DB::table('fans')->insert([
            'user_id' => 5,
        ]);
        DB::table('fans')->insert([
            'user_id' => 6,
        ]);
    }
}
