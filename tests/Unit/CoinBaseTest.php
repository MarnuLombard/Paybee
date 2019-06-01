<?php

namespace Tests\Unit;

use Jimmerioles\BitcoinCurrencyConverter\Converter;
use Tests\TestCase;

class CoinBaseTest extends TestCase
{
    public function testConverterInstanceExists()
    {
        $this->assertInstanceOf(Converter::class, app('\Converter'));
    }
}
