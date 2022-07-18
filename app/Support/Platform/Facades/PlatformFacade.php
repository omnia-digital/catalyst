<?php

namespace App\Support\Platform\Facades;

use Illuminate\Support\Facades\Facade;

class PlatformFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'platform';
    }
}
