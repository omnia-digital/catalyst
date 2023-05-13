<?php

namespace Modules\Livestream\Services;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Modules\Livestream\SocialAccount;
use Modules\Livestream\User;

class SocialiteService extends Service
{
    /**
     * This handles several types of requests: (in order to avoid code duplication)
     * 1) Handle callback from provider, in which we will either login (if social account exists), or redirect to register form
     * 2)
     *
     *
     * @return mixed
     */
    public function loginOrRegister(SocialiteUserContract $socialiteUser, $provider, Request $request)
    {
        // Try to find SocialAccount
        $socialAccount = SocialAccount::whereProvider($provider)
            ->whereProviderUserId($socialiteUser->getId())
            ->first();

        // @TODO [Josh] - we need to keep in mind that this could also be coming from a mobile app eventually, so we need to figure out how we are going to deal with that
        // @TODO [Josh] - I could have these urls as default and then check if the client passed a url, then use that as the redirect instead

        if (empty($socialAccount)) {
            if ($user = auth()->user()) {
                // this means they are on the streamIntegration page or the profile
                // if social account doesn't exist, but user is logged in, register the social account with the user
                $this->registerSocialAccountToUser($socialiteUser, $provider, $user);
                // redirect to the callback and let the client determine where they started this process
                return redirect(config('app.full_app_url') . 'oauth/callback');
            } else {
                // this means the user is on the login or register page, so we need to store the social info for retrieval from client side
                // we could check if this user exists and send that back as well so it's easy to tell

                // Check if user exists using email, if so, log them in automatically
                $user = User::where('email', '=', $socialiteUser->getEmail())->first();

                if (! empty($user)) {
                    $userExists = true;
                } else {
                    $userExists = false;
                }

                $social_info = $this->buildSocialInfo($socialiteUser, $provider, $request, $userExists);

                // get unique $token to store using provider name as prefix
                $token = uniqid(md5($socialiteUser->getId() . $social_info['provider']));

                Cache::set($token, $social_info, now()->addMinutes(5));

                // then the client side would know where to look for it using a signature token
                return $this->redirectToSocialRegisterForm($token);
            }
        } else {
            return $this->loginSocialAccount($socialAccount);
        }
    }

    /**
     * Login Social Account that has a user linked and Redirect
     *
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function loginSocialAccount(SocialAccount $socialAccount)
    {
        if (empty($socialAccount->user)) {
            throw new Exception('Social Account doesn\'t have a linked user; Cannot Login');
        } else {
            auth()->login($socialAccount->user);

            return redirect(config('app.full_app_url'));
        }
    }

    /**
     * @return mixed
     */
    public function redirectToSocialRegisterForm($token)
    {
        return redirect(config('app.full_app_url') . 'oauth/callback/' . $token);
    }

    /**
     * Create Social Account and attach to User
     *
     *
     * @return SocialAccount
     */
    public function registerSocialAccountToUser($providerUser, $provider, User $user)
    {
        $socialAccountData = [
            'provider_user_id' => $providerUser['id'],
            'provider' => $provider,
        ];
        unset($providerUser['id']);
        foreach ($providerUser as $attribute => $value) {
            if (! empty($value)) {
                $socialAccountData[$attribute] = $value;
            }
        }

        // If we have an Omnia user, create a new Social Account and link them
        $socialAccount = new SocialAccount;
        $socialAccount->fill($socialAccountData);

        // link user to SocialAccount
        $socialAccount->user()->associate($user);
        $socialAccount->save();

        return $socialAccount;
    }

    /**
     * Buid Social Info Object
     *
     *
     * @return array
     */
    private function buildSocialInfo(SocialiteUserContract $socialiteUser, $provider, Request $request, $userExists = false)
    {
        return [
            'code' => $request->code,
            'state' => $request->state,
            'user' => json_encode($socialiteUser, JSON_FORCE_OBJECT),
            'provider' => $provider,
            'user_exists' => $userExists,
        ];
    }
}
