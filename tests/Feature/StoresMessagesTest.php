<?php

namespace Tests\Feature;

use BotMan\BotMan\Http\Curl;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class StoresMessagesTest extends TestCase
{
    use DatabaseMigrations;
    use InteractsWithDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->runDatabaseMigrations();
        $this->seed(\UsersTableSeeder::class);
    }

    /**
     * Are the messages that come in stored
     *
     * @return void
     */
    public function testStoresIncomingMessages()
    {
        $data = require base_path('tests/Fixtures/TelegramMessage.php');
        $id = $data['message']['from']['id'];
        $firstName = $data['message']['chat']['first_name'];
        $lastName = $data['message']['chat']['last_name'];

        // Botman uses `Request::createFromGlobals()` to get the request data
        // Laravel's http testing doesn't perform the actual http request,
        // it just sends a Request object through the router
        // Therefor the $_GET, $_POST are empty - and `Request::createFromGlobals()` is empty
        // We need to create the actual http request to perform this test
        // Luckily Botman provides a lovely `curl` wrapper for us

        /** @var Response $response */
        $response = (new Curl())->post(url('/api/bot'), [], $data, ['Content-type' => 'application/json'], true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('messages', [
            'sender_id' => $id,
            'sender_first_name' => $firstName,
            'sender_last_name' => $lastName,
        ], 'mysql');
    }
}
