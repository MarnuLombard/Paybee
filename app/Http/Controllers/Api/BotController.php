<?php

namespace PayBee\Http\Controllers\Api;

use BotMan\BotMan\BotMan;

class BotController
{
    /** @var BotMan */
    private $botMan;

    public function __construct ()
    {
        $this->botMan = app('botman');
    }

    public function main()
    {
        $this->botMan->listen();
    }
}
