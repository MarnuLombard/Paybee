<?php

namespace PayBee\Bot\Commands;

use BotMan\BotMan\BotMan;
use PayBee\Models\User;

class UserIdCommand implements BotCommand
{
    /**
     * All bot commands should have only this method publicly
     * They are to be passed as the second parameter to `BotMan::hears()`
     * The first param is always an instance of the `BotMan` class,
     * Any further params are captured by the `{}` in the `hears()` definition
     *
     * @param BotMan $botMan
     *
     * @return void
     */
    public function handle(BotMan $botMan): void
    {
        $payload = $botMan->getMessage()->getPayload();
        $senderId = $payload->get('from')['id'];

        $user = User::where('sender_id', $senderId)->first();

        if (!$user) {
            $message = sprintf(
                'We can\'t find a registered user for you. Please register at %s, and see your token on your dashboard. Connect using the %s command.',
                route('register'),
                '/connectAccount'
            );

            $botMan->reply($message);

            return;
        }

        $botMan->reply("Your user id is {$user->id}.");
    }
}
