<?php

namespace App\Providers;

use App\Providers\CoinMarketCap\Api;

use Illuminate\Support\ServiceProvider;

class CoinMarketCapServiceProvider extends ServiceProvider
{   
    protected $defer = true;
    public function boot()
    {   

        $config = realpath(__DIR__.'/../config/coinmarketcap.php');

        $this->publishes([

            $config => config_path('coinmarketcap.php')

        ]);
    }

    public function register()
    {

        $this->app->singleton('coinmarketcap', function() {

            return new Api();
            
        });
    }

    public function provides()
    {
        return ['coinmarketcap'];
    }
}