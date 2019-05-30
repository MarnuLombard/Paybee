<?php

namespace PayBee\Http\Middleware\Bot;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Interfaces\Middleware\Received;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;

class ReceiveMiddleware implements Received
{
    /**
     * Handle an incoming message.
     *
     * @param IncomingMessage $message
     * @param callable $next
     * @param BotMan $bot
     *
     * @return mixed
     */
    public function received(IncomingMessage $message, $next, BotMan $bot)
    {
        // In a production environment, it would be better to fire off an event that can be queued
        // That way we essentially get asynchronous db inserts
        // For this projects we will insert inline.

        // Wrap in a try catch as capturing the data isn't as important as serving the request.
        // Ideally \Log::error() would get pushed to Rollbar, or Sentry or some other direct error management
        try {
            // Do some Work
        } catch (\Throwable $e) {
            \Log::error('Error persisting incoming message from Telegram', array_wrap($message->getPayload()));
        }

        return $next($message);
    }
}
