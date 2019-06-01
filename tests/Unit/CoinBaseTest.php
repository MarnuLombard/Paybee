<?php

namespace Tests\Unit;

use Jimmerioles\BitcoinCurrencyConverter\Converter;
use Tests\TestCase;

class CoinBaseTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testConverterInstanceExists()
    {
        $this->assertInstanceOf(Converter::class, app('\Converter'));
    }
}
