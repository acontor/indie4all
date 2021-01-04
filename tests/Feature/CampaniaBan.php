<?php

namespace Tests\Feature;

use App\Models\Campania;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CampaniaBan extends TestCase
{
    /**
     * @test
     */
    public function ban_campania()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $campania = Campania::find(1);
        $this->post('/admin/campania/' . $campania->id . '/ban');

        $desarrolladora = Campania::find(1);

        $this->assertEquals($desarrolladora->ban, '1');
    }
    /**
     * @test
     */
    public function unBan_campania()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $campania = Campania::find(1);
        $this->post('/admin/campania/' . $campania->id . '/unban');

        $campania = Campania::find(1);

        $this->assertEquals($campania->ban, '0');
    }
}
