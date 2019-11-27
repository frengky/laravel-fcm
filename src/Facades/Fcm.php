<?php

namespace Frengky\Fcm\Facades;

use Illuminate\Support\Facades\Facade;

class Fcm extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'fcm';
    }
}