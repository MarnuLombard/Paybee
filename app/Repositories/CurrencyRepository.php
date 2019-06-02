<?php

namespace PayBee\Repositories;

use GuzzleHttp\Exception\GuzzleException;
use Jimmerioles\BitcoinCurrencyConverter\Converter;
use Jimmerioles\BitcoinCurrencyConverter\Exception\ExceptionInterface as ConverterException;

class CurrencyRepository
{
    const BITCOIN = 'BTC';
    const ETHEREUM = 'ETH';
    const RANDS = 'ZAR';
    const US_DOLLARS = 'USD';

    const DEFAULT = self::RANDS;


    /** @var Converter */
    private $converter;

    public function __construct (Converter $converter)
    {
        $this->converter = $converter;
    }

    public function convertCurrency(string $from = self::BITCOIN, string $to = self::DEFAULT, float $amount = 1.00)
    {
        try {
            if ($to === self::BITCOIN) {
                $converted = $this->converter->toBtc($amount, $from);
            } else {
                $converted = $this->converter->toCurrency($to, $amount);
            }

            return $converted;
        } catch (ConverterException|GuzzleException $e) {
            \Log::error($e->getMessage(), $e->getTrace());
        }
    }
}
