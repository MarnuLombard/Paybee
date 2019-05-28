<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BotEndPointTest extends TestCase
{
    /**
     * A *very* simple test to check that our endpoint registered with telegram is alive and well
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->post('/api/bot', []);

        $response->assertStatus(200);
    }
}
