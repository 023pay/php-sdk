<?php

namespace ShanchengPay\Laravel;

use Illuminate\Support\Facades\Facade;

class ShanchengPay extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return '023pay';
    }
}
