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
        $id = $this->faker->numberBetween(1, 20000);
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $text = $this->faker->text(50);
        $data = [
            'update_id' => $this->faker->randomNumber(6),
            'message' =>
                [
                    'message_id' => 106,
                    'from' =>
                        [
                            'id' => $id,
                            'is_bot' => false,
                            'first_name' => $firstName,
                            'last_name' => $lastName,
                            'language_code' => 'en',
                        ],
                    'chat' =>
                        [
                            'id' => $id,
                            'first_name' => $firstName,
                            'last_name' => $lastName,
                            'type' => 'private',
                        ],
                    'date' => 1559287537,
                    'text' => $text,
                ],
        ];

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
