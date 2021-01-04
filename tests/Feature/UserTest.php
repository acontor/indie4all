<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{

    /**
     * @test
     */
    public function create_user()
    {
        $user = User::find(2);
        $this->actingAs($user);
        $response = $this->post('/admin/usuarios/store', [
            'name' => 'test',
            'username' => 'test',
            'email' => 'test@mail',
            'password' => Hash::make('password'),
        ]);

        $userL = User::latest()->first();

        $this->assertEquals($userL->name, 'test');
        $this->assertEquals($userL->email, 'test@test');
        return $response;
    }

    /**
     * @test
     */
    public function edit_user()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $this->patch('/admin/usuarios/10/update', [
            'name' => 'test2',
            'email' => 'test2@mail',
        ]);
        $userToEdit = User::find(4);
        $this->assertEquals($userToEdit->name, 'test2');
    }

    /**
     * @test
     */
    public function delete_user()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $totalUsers = User::count() - 1;
        $this->delete('/admin/usuarios/10/delete');
        $this->assertCount($totalUsers, User::all());
    }
}
