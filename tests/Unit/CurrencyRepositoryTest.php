<?php

namespace Tests\Unit;

use PayBee\Repositories\CurrencyRepository;
use Tests\TestCase;

class CurrencyRepositoryTest extends TestCase
{
    public function testConvertCurrency()
    {
        /** @var CurrencyRepository $repo */
        $repo = app(CurrencyRepository::class);
        // Do not use the `CurrencyRepository` constants here,
        // We need to emulated outside input
        $converted = $repo->convertCurrency('ZAR', 'BTC', 3);
        $this->assertIsFloat($converted);

        $converted = $repo->convertCurrency('ZAR', 'BTC', 3);
        $this->assertIsFloat($converted);
    }

    public function testCurrencyRepositoryCache()
    {
        /** @var CurrencyRepository $repo */
        $repo = app(CurrencyRepository::class);

        $repo->cacheRate('ZAR', 'BTC', 1);
        $rate = $repo->getCachedValue('ZAR', 'BTC');

        $this->assertEquals($rate, 1);
    }
}
