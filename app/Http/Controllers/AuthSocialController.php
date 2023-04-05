<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Support\Platform\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthSocialController extends Controller
{
    public function redirect(Request $request, $provider)
    {
        $scopes = config("services.$provider.scopes");
        $driver = Socialite::driver($provider)->redirectUrl(config("services.$provider.redirect"));
        if ($scopes) {
            $driver->setScopes($scopes);
        }
        return $driver->redirect();
    }

    public function callback(Request $request, $provider)
    {
        dd($request);
        $user = Socialite::driver($provider)->user();
        dd($user);
        $socialAccount = SocialAccount::findByProvider($provider, $user->getId());

        // A Facebook account cannot be registered without an email,
        // so we need to redirect them to registration form to force user to fill them email
        if (is_null($user->getEmail()) && ! $socialAccount) {
            [$firstName, $lastName] = Platform::extractFullName($user->getName());

            /// Put user data from social provider to session,
            ///  so we can grab it from registration page.
            session()->put($provider . $user->getId(), $user);

            return redirect()->route('register', [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'social-provider' => $provider,
                'provider_user_id' => $user->getId(),
            ]);
        }

        Auth::login(User::createUserFromFacebook($user), true);

        return redirect()->to(RouteServiceProvider::HOME);
    }
}
