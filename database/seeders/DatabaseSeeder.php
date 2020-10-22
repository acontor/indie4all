<?php

namespace Database\Seeders;

use App\Models\Desarrolladora;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            DesarrolladoraSeeder::class,
            DesarrolladoraUserSeeder::class,
            LogroSeeder::class,
            JuegoSeeder::class,
        ]);
    }
}
