<?php

namespace Modules\Social\Http\Middleware;

use App\Settings\GeneralSettings;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ((new GeneralSettings)->allow_guest_access) {
            return $next($request);
        }

        if (Auth::check()) {
            return $next($request);
        }

        return redirect()->route('login');
    }
}
