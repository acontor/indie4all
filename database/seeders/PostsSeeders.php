<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            'titulo' => '¿Formas parte de una desarrolladora?',
            'contenido' => '<p>&iexcl;Buenas apasionados de los juegos indies!</p>

            <p>&nbsp;</p>

            <p>&iquest;Tienes en mente crear tus propios juegos?</p>

            <p>&iquest;Formas parte de una peque&ntilde;a desarrolladora?</p>

            <p>&nbsp;</p>

            <p>&iexcl;&Eacute;sta es una oportunidad &uacute;nica!. &Uacute;nete a nuestra comunidad y empieza a vender tus juegos, realiza tus anuncios importantes o&nbsp;conecta con tu p&uacute;blico.&nbsp; Si est&aacute;s pensando en lanzar un juego, aqu&iacute; tendr&aacute;s la oportunidad de crear una campa&ntilde;a de financiaci&oacute;n para llevarlo a buen puerto.</p>

            <p>&nbsp;</p>

            <p><a href="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/desarrolladoras/solicitud">Realizar solicitud</a></p>

            <p>&nbsp;</p>

            <p>&iexcl;Te esperamos con los brazos abiertos!</p>',
            'destacado' => true,
        ]);
        DB::table('posts')->insert([
            'titulo' => 'Nuevo juego en camino',
            'contenido' => '<p>&iexcl;Queremos anunciaros que hemos empezado el desarrollo de nuestro nuevo juego!</p>

            <p>&nbsp;</p>

            <p>Pronto ir&eacute;is conociendo muchos detalles y realizaremos el anuncio mediante nuestra comunidad de juegos Indie4all.</p>

            <p>&nbsp;</p>

            <p>S&oacute;lo queremos adelantar que prepares tu sombrero y las espuelas&nbsp;porque haremos que nuestros enemigos muerdan el polvo.</p>',
            'destacado' => true,
            'desarrolladora_id' => 1,
        ]);
        DB::table('mensajes')->insert([
            'contenido' => '<p>Estamos deseando saber m&aacute;s!</p>',
            'post_id' => 2,
            'user_id' => 1,
        ]);
    }
}
