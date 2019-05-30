<?php

namespace Tests\Feature;

use Tests\TestCase;

class BotEndPointTest extends TestCase
{
    /**
     * A *very* simple test to check that our endpoint registered with telegram is alive and well
     *
     * @return void
     */
    public function testEndpointResponds()
    {
        $response = $this->post('/api/bot', []);

        $response->assertStatus(200);
    }
}
