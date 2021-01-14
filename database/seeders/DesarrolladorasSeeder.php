<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DesarrolladorasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('desarrolladoras')->insert([
            'nombre' => '2D Trassierra',
            'email' => '2dtrassierra@mail.com',
            'direccion' => 'Avenida Arroyo del Moro, s/n, 14011 Córdoba',
            'telefono' => '957 73 49 00',
            'url' => 'www.iestrassierra.com',
            'contenido' => '<h1><strong>2D Trassierra</strong></h1>

            <p>&nbsp;</p>

            <p>Nos caracterizamos por ser una empresa que realiza juegos en formato 2D y est&eacute;tica Pixel Art. Siempre intentamos que nuestra base de fans participe de alg&uacute;n modo en la creaci&oacute;n de nuestras obras.</p>

            <p>&nbsp;</p>

            <p><img alt="" src="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/public/images/posts/banner05-1024x256_1606837024.png" style="height:125px; width:500px" /></p>

            <p>&nbsp;</p>

            <p>Llevamos en el sector m&aacute;s de 10 a&ntilde;os y nuestro actual grupo se conforma de j&oacute;venes talentos con una visi&oacute;n de los videojuegos &uacute;nica. Intentamos llevar a lo m&aacute;s alto los g&eacute;neros de aventura, rol y terror.</p>',
        ]);
        DB::table('cms')->insert([
            'desarrolladora_id' => 1,
            'user_id' => 5,
        ]);
        DB::table('desarrolladoras')->insert([
            'nombre' => 'Turismo Studios',
            'email' => 'turismostudios@mail.com',
            'direccion' => 'Calle Gran Vía, 11, 28013 Madrid',
            'telefono' => '911 11 11 11',
            'url' => 'www.turismostudios.com',
        ]);
        DB::table('cms')->insert([
            'desarrolladora_id' => 2,
            'user_id' => 6,
        ]);
    }
}
