<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ResetsPasswords
{
    use \Illuminate\Foundation\Auth\ResetsPasswords;

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('spark::auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}