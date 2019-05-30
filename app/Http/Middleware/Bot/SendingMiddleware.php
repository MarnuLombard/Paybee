<?php

namespace PayBee\Http\Middleware\Bot;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Interfaces\Middleware\Sending;

class SendingMiddleware implements Sending
{
    /**
     * Handle an outgoing message payload before/after it
     * hits the message service.
     *
     * @param mixed    $payload
     * @param callable $next
     * @param BotMan   $bot
     *
     * @return mixed
     */
    public function sending($payload, $next, BotMan $bot)
    {
        // In a production environment, it would be better to fire off an event that can be queued
        // That way we essentially get asynchronous db inserts
        // For this projects we will insert inline.

        // Wrap in a try catch as capturing the data isn't as important as serving the request.
        // Ideally \Log::error() would get pushed to Rollbar, or Sentry or some other direct error management
        try {
            // Do some Work
        } catch (\Throwable $e) {
            \Log::error('Error persisting incoming message from Telegram', array_wrap(method_exists($payload, 'getPayload') ? $payload->getPayload() : $payload));
        }

        return $next($payload);
    }
}
