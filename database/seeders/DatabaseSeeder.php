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
            UsuariosSeeder::class,
            DesarrolladorasSeeder::class,
            GenerosSeeder::class,
            JuegosSeeder::class,
            LogrosSeeder::class,
            GeneroUsuarioSeeder::class,
            JuegoUsuarioSeeder::class,
            PostsSeeders::class,
        ]);
    }
}
