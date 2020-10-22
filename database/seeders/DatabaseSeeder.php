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
            DesarrolladoraUserSeeder::class,
            LogrosSeeder::class,
            GenerosSeeder::class,
            SolicitudDesarrolladoraSeeder::class,
            JuegosSeeder::class,
        ]);
    }
}
