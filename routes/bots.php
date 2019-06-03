<?php

/** @var \BotMan\BotMan\BotMan $botMan */
$botMan = app('botman');


$botMan->hears('/getBTCEquivalent {amount} {currency}', PayBee\Bot\Commands\BtcCommand::class.'@handle');
$botMan->fallback(PayBee\Bot\Commands\FallBackCommand::class.'@handle');
