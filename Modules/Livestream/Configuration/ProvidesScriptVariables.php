<?php

namespace Modules\Livestream\Configuration;

use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Cashier;
use Laravel\Spark\Contracts\InitialFrontendState;
use Modules\Livestream\Omnia;

trait ProvidesScriptVariables
{
    /**
     * Get the default JavaScript variables for Omnia.
     *
     * @return array
     */
    public static function scriptVariables()
    {
        if ($user = auth()->user()) {
            if ($user->isBanned()) {
                return self::getBannedState();
            } else {
                return self::getInternalState();
            }
        } else {
            return self::getExternalState();
        }
    }

    /**
     * Get the translation keys from file.
     *
     * @return array
     */
    private static function getTranslations()
    {
        $translationFile = resource_path('lang/' . app()->getLocale() . '.json');

        if (! is_readable($translationFile)) {
            $translationFile = resource_path('lang/' . app('translator')->getFallback() . '.json');
        }

        return json_decode(file_get_contents($translationFile), true);
    }

    private static function getBannedState()
    {
        $state = self::getExternalState();
        $state['banned'] = true;

        return $state;
    }

    private static function getInternalState()
    {
        return [
            'translations' => static::getTranslations() + ['teams.team' => trans('teams.team'), 'teams.member' => trans('teams.member')],
            'cardUpFront' => Omnia::needsCardUpFront(),
            'collectsBillingAddress' => Omnia::collectsBillingAddress(),
            'collectsEuropeanVat' => Omnia::collectsEuropeanVat(),
            'createsAdditionalTeams' => Omnia::createsAdditionalTeams(),
            'csrfToken' => csrf_token(),
            'currencySymbol' => Cashier::usesCurrencySymbol(),
            'env' => config('app.env'),
            'roles' => Omnia::roles(),
            'state' => Omnia::call(InitialFrontendState::class . '@forUser', [auth()->user()]),
            'stripeKey' => config('services.stripe.key'),
            'teamsPrefix' => Omnia::teamsPrefix(),
            'teamString' => Omnia::teamString(),
            'pluralTeamString' => Omnia::teamsPrefix(),
            'userId' => auth()->id(),
            'usesApi' => Omnia::usesApi(),
            'usesTeams' => Omnia::usesTeams(),
            'usesStripe' => Omnia::billsUsingStripe(),
            'chargesUsersPerSeat' => Omnia::chargesUsersPerSeat(),
            'seatName' => Omnia::seatName(),
            'chargesTeamsPerSeat' => Omnia::chargesTeamsPerSeat(),
            'teamSeatName' => Omnia::teamSeatName(),
            'chargesUsersPerTeam' => Omnia::chargesUsersPerTeam(),
            'chargesTeamsPerMember' => Omnia::chargesTeamsPerMember(),
            'onlyTeamPlans' => Omnia::onlyTeamPlans(),
            'teamsIdentifiedByPath' => Omnia::teamsIdentifiedByPath(),
            'impersonator' => (bool) session('spark:impersonator'),
            'intercomUserHash' => (auth()->check() ? hash_hmac('sha256', auth()->user()->id, env('INTERCOM_VERIFICATION_SECRET')) : null),
            'appVersion' => Omnia::$version,
            //            'usesBraintree' => Omnia::billsUsingBraintree(),
            //            'braintreeMerchantId' => config('services.braintree.merchant_id'),
            //            'braintreeToken' => Omnia::billsUsingBraintree() ? BraintreeClientToken::generate() : null,
        ];
    }

    /**
     * The state we want to return when User isn't logged in or request is from an external site
     * This is where data should be very protected
     *
     * @return array
     */
    private static function getExternalState()
    {
        return [
            'env' => config('app.env'),
            'translations' => static::getTranslations() + ['teams.team' => trans('teams.team'), 'teams.member' => trans('teams.member')],
            //            'state' => Omnia::call(InitialFrontendState::class.'@forUser', [Auth::user()]),
            'state' => [
                'currentTeam' => [],
                'teams' => [],
                'user' => [],
            ],
            'teamString' => Omnia::teamString(),
        ];
    }
}
