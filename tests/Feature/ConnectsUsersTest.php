<?php

namespace Tests\Feature;

use BotMan\BotMan\Http\Curl;
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
        // Use the default connection as that's what we store it in through the framework
        $user = factory(User::class)->connection('mysql')->create();
        $data = require base_path('tests/Fixtures/TelegramMessage.php');
        $data['message']['text'] = "/connectAccount {$user->token->token}";

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

        // We are forced to use the mysql database due to the new http request being posted
        // Ensure we delete the records we create
        $user->token->delete();
        $user->messages->each->delete();
        $user->delete();
    }
}
