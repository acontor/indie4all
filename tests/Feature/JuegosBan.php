<?php

namespace Tests\Feature;

use App\Models\Juego;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JuegosBan extends TestCase
{
    /**
     * @test
     */
    public function ban_juego()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $juego = Juego::find(1);
        $this->post('/admin/juego/' . $juego->id . '/ban');

        $juego = juego::find(1);

        $this->assertEquals($juego->ban, '1');
    }
    /**
     * @test
     */
    public function unBan_juego()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $juego = Juego::find(1);
        $this->post('/admin/juego/' . $juego->id . '/unban');

        $juego = Juego::find(1);

        $this->assertEquals($juego->ban, '0');
    }
}
