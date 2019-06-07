<?php

namespace Tests\Feature;

use BotMan\BotMan\Http\Curl;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use PayBee\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ConnectsUsersTest extends TestCase
{

    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->runDatabaseMigrations();
        $this->seed(\UsersTableSeeder::class);
    }

    /**
     * Test whether
     *
     * @return void
     */
    public function testUserConnectionIsStored()
    {
        /** @var User $user */
        $user = factory(User::class)->create();
        $data = require base_path('tests/Fixtures/TelegramMessage.php');
        $data['message']['text'] = "/connect {$user->token->token}";

        $id = $data['message']['from']['id'];

        // Botman uses `Request::createFromGlobals()` to get the request data
        // Laravel's http testing doesn't perform the actual http request,
        // it just sends a Request object through the router
        // Therefor the $_GET, $_POST are empty - and `Request::createFromGlobals()` is empty
        // We need to create the actual http request to perform this test
        // Luckily Botman provides a lovely `curl` wrapper for us

        /** @var Response $response */
        $response = (new Curl())->post(url('/api/bot'), [], $data, ['Content-type' => 'application/json'], true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('users', [
            'sender_id' => $id,
        ], 'mysql');

    }
}
