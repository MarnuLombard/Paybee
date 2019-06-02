<?php

namespace PayBee\Providers;

use GuzzleHttp\Client;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Jimmerioles\BitcoinCurrencyConverter\Converter;
use Jimmerioles\BitcoinCurrencyConverter\Provider\CoinbaseProvider;
use PayBee\Repositories\CurrencyRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Bind our crypto currency converter instance into the IOC container
        $this->app
            ->when(CurrencyRepository::class)
            ->needs(Converter::class)
            ->give(function (Application $app) {
                return new Converter(new CoinbaseProvider(new Client(), $app->make('cache.store'), 10*60));
            });

    }
}
