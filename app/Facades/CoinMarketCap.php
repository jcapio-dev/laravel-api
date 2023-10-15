<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class CoinMarketCap extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'coinmarketcap';
    }
}