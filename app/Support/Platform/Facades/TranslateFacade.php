<?php

namespace App\Support\Platform\Facades;

use Illuminate\Support\Facades\Facade;

class TranslateFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'trans';
    }
}
