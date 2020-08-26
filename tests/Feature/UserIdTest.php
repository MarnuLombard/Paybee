<?php

namespace Tests\Feature;

use BotMan\BotMan\Http\Curl;
use PayBee\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserIdTest extends TestCase
{
    /**
     * Unfortunately because Telegram clients push to their
     * server instead of serving the info in a response,
     * We really can't test the content of this, just that it doesn't error out
     *
     * @return void
     */
    public function testUserIdEndpoint()
    {
        /** @var User $user */
        // Use the default connection as that's what we store it in through the framework
        $data = require base_path('tests/Fixtures/TelegramMessage.php');
        $data['message']['text'] = "/getUserId";

        // Botman uses `Request::createFromGlobals()` to get the request data
        // Laravel's http testing doesn't perform the actual http request,
        // it just sends a Request object through the router
        // Therefor the $_GET, $_POST are empty - and `Request::createFromGlobals()` is empty
        // We need to create the actual http request to perform this test
        // Luckily Botman provides a lovely `curl` wrapper for us

        /** @var Response $response */
        $response = (new Curl())->post(url('/api/bot'), [], $data, ['Content-type' => 'application/json'], true);

        $this->assertEquals(200, $response->getStatusCode());
    }
}
