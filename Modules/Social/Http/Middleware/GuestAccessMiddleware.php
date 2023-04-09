<?php

namespace Modules\Social\Http\Middleware;

use App\Settings\GeneralSettings;
use Closure;
use Illuminate\Http\Request;

class GuestAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ((new GeneralSettings)->allow_guest_access) {
            return $next($request);
        }

        if (auth()->check()) {
            return $next($request);
        }

        return redirect()->route('login');
    }
}
