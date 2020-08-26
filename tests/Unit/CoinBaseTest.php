<?php

namespace Tests\Unit;

use Jimmerioles\BitcoinCurrencyConverter\Converter;
use Tests\TestCase;

class CoinBaseTest extends TestCase
{
    public function testConverterGetsData()
    {
        /** @var Converter $converter */
        $converter = app(Converter::class);
        $btc = $converter->toBtc(50, 'ZAR');
        $currency = $converter->toCurrency('USD', 50);

        $this->assertIsFloat($btc);
        $this->assertIsFloat($currency);
    }
}
