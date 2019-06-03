<?php

namespace PayBee\Http\Middleware\Bot;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Interfaces\Middleware\Received;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use PayBee\Models\Message;
use PayBee\Models\User;

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
            if (!$message->isFromBot()) {
                $from = $message->getPayload()->get('from', ['first_name' => null, 'last_name' => null]);
                $timestamp = $message->getPayload()->get('date', time());
                $senderId = $message->getSender();

                $user = User::where('sender_id', $senderId)->first();

                $messageRecord = Message::create([
                    'conversation_uuid' => $message->getConversationIdentifier(),
                    'direction' => Message::DIRECTION_INCOMING,
                    'user_id' => optional($user)->id,
                    'sender_id' => $senderId,
                    'sender_first_name' => $from['first_name'],
                    'sender_last_name' => $from['last_name'],
                    'text' => substr($message->getText(), 0, 65535),// 65,535 is the mysql text limit
                    'created_at' => date('Y-m-d H:i:s', $timestamp)
                ]);

                $message->addExtras('db_message', $messageRecord);
            }
        } catch (\Throwable $e) {
            \Log::error('Error persisting incoming message from Telegram', array_wrap($message->getPayload()));
        }

        return $next($message);
    }
}
