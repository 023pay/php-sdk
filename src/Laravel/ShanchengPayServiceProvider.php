<?php

namespace ShanchengPay\Laravel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use ShanchengPay\ShanchengPay;

class ShanchengPayServiceProvider extends ServiceProvider
{
    protected function prepareConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/config.php', '023pay');
    }

    public function register()
    {
        $this->prepareConfig();
        app()->singleton('023pay', function () {
            return new ShanchengPay(config('023pay.key_id'), config('023pay.key_secret'));
        });
    }
}
