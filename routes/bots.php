<?php

/** @var \BotMan\BotMan\BotMan $botMan */
$botMan = app('botman');

$botMan->hears('/getBTCEquivalent {amount} {currency}', PayBee\Bot\Commands\BtcCommand::class.'@handle');
$botMan->hears('/getUserID', PayBee\Bot\Commands\UserIdCommand::class.'@handle');
$botMan->hears('/connectAccount {code}', PayBee\Bot\Commands\ConnectCommand::class.'@handle');

$botMan->fallback(PayBee\Bot\Commands\FallBackCommand::class.'@handle');
