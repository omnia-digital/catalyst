<?php

namespace Modules\Livestream\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Modules\Livestream\Models\SocialAccount;
use Modules\Livestream\Models\User;
use Modules\Livestream\Omnia;
use Modules\Livestream\Providers\RouteServiceProvider;

class AuthSocialController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')
            //->setScopes(config('omnia.facebook_scopes'))
            ->redirect();
    }

    public function callback()
    {
        $provider = 'facebook';

        $user = Socialite::driver($provider)->user();
        $socialAccount = SocialAccount::findByProvider('facebook', $user->getId());

        // A Facebook account can be registered without an email,
        // so we need to redirect them to registration form to force user to fill them email
        if (is_null($user->getEmail()) && ! $socialAccount) {
            [$firstName, $lastName] = Omnia::extractFullName($user->getName());

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

        auth()->login(User::createUserFromFacebook($user), true);

        return redirect()->to(RouteServiceProvider::HOME);
    }
}
