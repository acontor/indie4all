<?php

namespace Tests\Feature;

use App\Models\Logro;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogrosTest extends TestCase
{
    /**
     * @test
     */
    public function create_logro()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $response = $this->post('/admin/logros', [
            'nombre' => 'test',
            'descripcion' => 'test',
        ]);

        $response->assertRedirect('/admin/logros');

        $logro = Logro::latest()->first();

        $this->assertEquals($logro->nombre, 'test');
        $this->assertEquals($logro->descripcion, 'test');
    }

    /**
     * @test
     */
    public function edit_logro()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $this->patch('/admin/logros/3/update', [ 
            'nombre' => 'nombre test2', 
            'descripcion' => 'descripcion test2'
        ]);
        $logro = Logro::find(3);
        
        $this->assertEquals($logro->nombre, 'nombre test2');
        $this->assertEquals($logro->descripcion, 'descripcion test2');
    }

    /**
     * @test
     */
    public function delete_logro()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $totalLogros = Logro::count() -1 ;
        $this->delete('/admin/logros/3/delete');
        $this->assertCount($totalLogros, Logro::all());
    }
}
