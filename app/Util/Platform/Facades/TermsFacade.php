<?php

namespace App\Util\Platform\Facades;

use Illuminate\Support\Facades\Facade;

class TermsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'terms';
    }
}
