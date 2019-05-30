<?php

namespace PayBee\Bot\Commands;

use BotMan\BotMan\BotMan;

class BtcCommand implements BotCommand
{
    /**
     * All bot commands should have only this method publicly
     * They are to be passed as the second parameter to `BotMan::hears()`
     * The first param is always an instance of the `BotMan` class,
     * Any further params are captured by the `{}` in the `hears()` definition
     *
     * @param BotMan $botMan
     *
     * @param int|null $amount
     * @param string|null $currency
     *
     * @return void
     */
    public function handle(BotMan $botMan, int $amount = null, string $currency = null): void
    {
        $botMan->reply("You asked for $amount of $currency to be converted correct?");
    }
}
