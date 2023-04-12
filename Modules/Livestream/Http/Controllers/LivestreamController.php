<?php

namespace Modules\Livestream\Http\Controllers;

use Livestream\Livestream;
use Modules\Livestream\Http\Controllers\Controller as OmniaController;

class LivestreamController extends OmniaController
{
    protected $_livestreamAccount;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->_livestreamAccount = Livestream::getLivestreamAccount();

            return $next($request);
        });
    }
}
