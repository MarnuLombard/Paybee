<?php

namespace PayBee\Providers;

use BotMan\BotMan\BotMan;
use Illuminate\Support\ServiceProvider;
use PayBee\Http\Middleware\Bot\ReceiveMiddleware;
use PayBee\Http\Middleware\Bot\SendingMiddleware;

class BotManMiddlewareServiceProvider extends ServiceProvider
{
    private $types = [
        'received',
        'captured',
        'matching',
        'heard',
        'sending',
    ];
    private $received = [
        ReceiveMiddleware::class,
    ];
    private $captured = [];
    private $matching = [];
    private $heard = [];
    private $sending = [
        SendingMiddleware::class,
    ];

    /**
     * BotMan middleware is grouped by certain events in the lifecycle (see `$types`)
     * These are fired off by the framework if they are bound by type in the bootup process of the app
     *
     * @see https://botman.io/2.0/middleware
     */
    public function boot()
    {
        /** @var BotMan $botMan */
        $botMan = app('botman');

        foreach ($this->types as $type) {
            foreach ($this->{$type} as $middleware) {
                $botMan->middleware->{$type}(new $middleware());
            }
        }
    }
}
