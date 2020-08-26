<?php

namespace PayBee\Bot\Commands;

use BotMan\BotMan\BotMan;
use PayBee\Models\Token;

class ConnectCommand implements BotCommand
{
    /**
     * All bot commands should have only this method publicly
     * They are to be passed as the second parameter to `BotMan::hears()`
     * The first param is always an instance of the `BotMan` class,
     * Any further params are captured by the `{}` in the `hears()` definition
     *
     * @param BotMan      $botMan
     * @param null|string $code
     *
     * @return void
     */
    public function handle(BotMan $botMan, $code = null): void
    {
        if (!$code || !strlen($code)) {
            $botMan->reply("Please enter a code to connect your account. You can find it on your dashboard");

            return;
        }

        /** @var Token $token */
        $token = Token::where('token', $code)->firstOrFail();
        $user = $token->user;

        $payload = $botMan->getMessage()->getPayload();
        $user->update(['sender_id' => $payload->get('from')['id']]);

        $botMan->reply("Account for {$user->email} connected.");
    }
}
