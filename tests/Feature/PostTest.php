<?php

namespace Tests\Feature;

use App\Models\Desarrolladora;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * @test
     */
    public function create_post()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $response = $this->post('/admin/noticias/nueva', [
            'titulo' => 'titulo test',
            'contenido' => 'contenido test'
        ]);

        $response->assertRedirect('/admin/noticias');

        $post = Post::latest()->first();

        $this->assertEquals($post->titulo, 'titulo test');
        $this->assertEquals($post->contenido, 'contenido test');
    }

    /**
     * @test
     */
    public function edit_post()
    {
        $user = User::find(1);  //Recibimos un usuario con el rol de admin.
        $this->actingAs($user); // Le indicamos al test que actue cómo tal.
        $post = Post::latest()->first();
        $this->patch('/admin/noticias/' . $post->id . '/update', [ //le decimos al test que comrpuebe esta ruta
            'titulo' => 'titulo test2', //actualizamos el titulo
            'contenido' => 'contenido test2' //actualizamos el contenido
        ]);
        $post = Post::latest()->first();
        //Comprobamos que los cambios se han efectuado
        $this->assertEquals($post->titulo, 'titulo test2');
        $this->assertEquals($post->contenido, 'contenido test2');
    }

    /**
     * @test
     */
    public function delete_post()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $post = Post::latest()->first();
        $this->delete('/admin/noticias/' . $post->id . '/delete');
        $this->assertCount(2, Post::all());
    }
}
