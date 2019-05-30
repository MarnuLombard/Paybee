<?php

$botMan = app('botman');


$botMan->hears('/getBTCEquivalent {amount} {currency}', PayBee\Bot\Commands\BtcCommand::class.'@handle');
