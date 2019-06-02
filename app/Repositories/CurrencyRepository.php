<?php

namespace PayBee\Repositories;

use GuzzleHttp\Exception\GuzzleException;
use Jimmerioles\BitcoinCurrencyConverter\Converter;
use Jimmerioles\BitcoinCurrencyConverter\Exception\ExceptionInterface as ConverterException;

class CurrencyRepository
{
    private const CACHE_TAG = 'currency_rates';

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

    public function convertCurrency(string $from = self::BITCOIN, string $to = self::DEFAULT, float $amount = 1.00): float
    {
        try {
            if ($to === self::BITCOIN) {
                $converted = $this->converter->toBtc($amount, $from);
            } else {
                $converted = $this->converter->toCurrency($to, $amount);
            }

            $this->cacheRate($from, $to, $amount / $converted);

            return $converted;
        } catch (ConverterException|GuzzleException $e) {
            \Log::error($e->getMessage(), $e->getTrace());

            return $this->getCachedValue($from, $to, $amount);
        }
    }

    public function cacheRate(string $from, string $to, float $rate): void
    {
        \Cache::tags(self::CACHE_TAG)
            ->put("$from:$to", $rate, now()->endOfDay());
        \Cache::tags(self::CACHE_TAG)
            ->put("$to:$from", 1/$rate, now()->endOfDay());

        return;
    }

    public function getCachedRate(string $from, string $to): float
    {
        return \Cache::tags(self::CACHE_TAG)
            ->get("$from:$to") ?: 0;
    }

    public function getCachedValue(string $from, string $to, float $amount): float
    {
        $rate = $this->getCachedRate($from, $to);

        return $amount * $rate;
    }
}
