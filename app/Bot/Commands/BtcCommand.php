<?php

namespace PayBee\Bot\Commands;

use BotMan\BotMan\BotMan;
use PayBee\Repositories\CurrencyRepository;

class BtcCommand implements BotCommand
{
    private $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * All bot commands should have only this method publicly
     * They are to be passed as the second parameter to `BotMan::hears()`
     * The first param is always an instance of the `BotMan` class,
     * Any further params are captured by the `{}` in the `hears()` definition
     *
     * @param BotMan $botMan
     *
     * @param float|null $amount
     * @param string|null $currency
     *
     * @return void
     */
    public function handle(BotMan $botMan, $amount = null, $currency = null): void
    {
        $amount = trim($amount);
        $currency = trim($currency);

        $message = $botMan->getMessage()->getExtras('db_message');

        if (!is_numeric($amount)) {
            $botMan->reply("Please give a numeric value for the amount eg : /getBTCEquivalent 30 USD", compact('message'));

            return;
        }

        if (!is_currency_code($currency)) {
            $botMan->reply("Please give a 3 letter currency code eg : /getBTCEquivalent 30 USD", compact('message'));

            return;
        }

        $converted = $this->currencyRepository->convertCurrency($currency, CurrencyRepository::BITCOIN, $amount);

        $converted = round($converted, 4);
        $rate = $this->currencyRepository->getCachedRate(CurrencyRepository::BITCOIN, $currency);
        $rate = round($rate, 2);

        $botMan->reply("$amount $currency is $converted BTC ($rate $currency - 1 BTC)", compact('message'));
    }
}
