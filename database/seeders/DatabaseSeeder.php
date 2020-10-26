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
<<<<<<< HEAD
            UsuariosSeeder::class,
            DesarrolladorasSeeder::class,
            DesarrolladoraUsuarioSeeder::class,
            LogrosSeeder::class,
            GenerosSeeder::class,
            GeneroUsuarioSeeder::class,
            SolicitudDesarrolladoraSeeder::class,
            JuegosSeeder::class,
            CmsSeeder::class,
            MastersSeeder::class,
            FansSeeder::class,
=======
            UserSeeder::class,
            DesarrolladoraSeeder::class,
            DesarrolladoraUserSeeder::class,
>>>>>>> 52796baaeab21bc29cd2a87ac161ad3947079819
        ]);
    }
}
