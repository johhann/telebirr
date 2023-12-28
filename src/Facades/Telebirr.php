<?php

namespace Johhann\Telebirr\Facades;

use Illuminate\Support\Facades\Facade;

class Telebirr extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'telebirr';
    }
}
