<?php

namespace App\Support\Platform\Facades;

use Illuminate\Support\Facades\Facade;

class TranslateFacade extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'trans';
    }
}
