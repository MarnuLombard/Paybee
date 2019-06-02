<?php

namespace Tests\Unit;

use Tests\TestCase;

class CurrencyRepositoryTest extends TestCase
{
    public function testConvertCurrency()
    {
        /** @var CurrencyRepository $repo */
        $repo = app(CurrencyRepository::class);
        $converted = $repo->convertCurrency('ZAR', 'BTC', 3);
        $this->assertIsFloat($converted);

        $converted = $repo->convertCurrency('ZAR', 'BTC', 3);
        $this->assertIsFloat($converted);
    }
}
