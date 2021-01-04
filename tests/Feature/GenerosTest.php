<?php

namespace Tests\Feature;

use App\Models\Genero;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GenerosTest extends TestCase
{
    /**
     * @test
     */
    public function create_genero()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $response = $this->post('/admin/generos', [
            'nombre' => 'test',
        ]);

        $response->assertRedirect('/admin/generos');

        $genero = Genero::latest()->first();

        $this->assertEquals($genero->nombre, 'test');
    }

    /**
     * @test
     */
    public function edit_genero()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $response = $this->patch('/admin/generos/1/update', [
            'nombre' => 'test2',
        ]);
        $response->assertRedirect('/admin/generos');
        $genero = Genero::find(1);
        $this->assertEquals($genero->nombre, 'test2');
    }

    /**
     * @test
     */
    public function delete_genero()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $totalLogros = Genero::count() -1 ;
        $this->delete('/admin/generos/1/delete');
        $this->assertCount($totalLogros, Genero::all());
    }
}
