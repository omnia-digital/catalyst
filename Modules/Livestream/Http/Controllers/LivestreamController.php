<?php

namespace Modules\Livestream\Http\Controllers;


use App\Http\Controllers\Controller as OmniaController;
use Livestream\Livestream;

class LivestreamController extends OmniaController
{
    protected $_livestreamAccount;

    public function __construct() {
	    $this->middleware(function ($request, $next) {

		    $this->_livestreamAccount = Livestream::getLivestreamAccount();

		    return $next($request);
	    });
    }
}
