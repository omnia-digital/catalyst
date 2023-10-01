<?php

namespace Modules\Livestream\Traits;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

trait ResetsPasswords
{
    use \Illuminate\Foundation\Auth\ResetsPasswords;

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  string|null  $token
     * @return Factory|View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('spark::auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
