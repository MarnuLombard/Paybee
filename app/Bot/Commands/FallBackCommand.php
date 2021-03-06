<?php

namespace PayBee\Bot\Commands;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;

class FallBackCommand implements BotCommand
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
        /** @var IncomingMessage $message */
        $message = $botMan->getMessage();
        $message->getPayload();
        $replyText = sprintf(
            "\"{$message->getText()}\" is not a valid command. \nValid command are:\n".
            str_repeat("%s\n", 3), // 3 commands
            '/getBTCEquivalent {amount} {currency-code} (eg /getBTCEquivalent 1 ETH)',
            '/connectAccount {token}',
            '/getUserId'
        );
        $botMan->reply($replyText);
    }
}
