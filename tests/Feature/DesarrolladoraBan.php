<?php

namespace Tests\Feature;

use App\Models\Desarrolladora;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DesarrolladoraBan extends TestCase
{
    /**
     * @test
     */
    public function ban_desarrolladora()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $desarrolladora = Desarrolladora::find(1);
        $this->post('/admin/desarrolladora/' . $desarrolladora->id . '/ban');

        $desarrolladora = Desarrolladora::find(1);

        $this->assertEquals($desarrolladora->ban, '1');
    }
    /**
     * @test
     */
    public function unBan_desarrolladora()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $desarrolladora = Desarrolladora::find(1);
        $this->post('/admin/desarrolladora/' . $desarrolladora->id . '/unban');

        $desarrolladora = Desarrolladora::find(1);

        $this->assertEquals($desarrolladora->ban, '0');
    }
}
