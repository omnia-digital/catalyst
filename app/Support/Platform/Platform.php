<?php

namespace App\Support\Platform;





use App\Settings\BillingSettings;
use App\Settings\GeneralSettings;
use Nwidart\Modules\Facades\Module;

class Platform
{
    public function isModuleEnabled($moduleName)
    {
        $modules = collect(Module::allEnabled());

        $contains = $modules->contains(function ($value, $key) use ($moduleName) {
            return $moduleName === $value->getLowerName();
        });

        if ($contains) {
            return true;
        }

        return false;
    }

    public function translate($string): string
    {
        $wordsInString = explode(' ', $string);

        $newWordString = '';
        foreach ($wordsInString as $originalWord) {
            $lowercase   = strtolower($originalWord);
            $capitalized = ucfirst($originalWord);
            $singular    = \Str::singular($lowercase);
            $plural      = \Str::plural($lowercase);
            $newWord     = $lowercase;
            if (\Lang::has('platform_terms.' . $singular)) {
                $amount = 1;
                if ($lowercase == $plural) {
                    $amount = 2;
                }
                $newWord = trans_choice('platform_terms.' . $singular, $amount);
            }

            // Checks if first letter is capitalized of the original word
            if (ctype_upper(substr($originalWord, 0, 1))) {
                $newWord = ucfirst($newWord);
            } else {
                $newWord = strtolower($newWord);
            }

            $newWordString .= $newWord . ' ';
        }

        $newWordString = rtrim($newWordString);

        return __($newWordString);
    }

    // General Settings //

    public static function hasGeneralSettingEnabled($setting)
    {
        return (new GeneralSettings())->{$setting} === true;
    }

    public static function getGeneralSetting($setting)
    {
        return (new GeneralSettings())->{$setting};
    }

    public static function applyButtonText()
    {
        return \Trans::get(self::getGeneralSetting('teams_apply_button_text') ?? 'Apply');
    }

    //Billing Settings //

    public static function hasBillingSettingEnabled($setting)
    {
        return (new BillingSettings())?->{$setting} === true;
    }

    public static function getBillingSetting($setting)
    {
        return (new BillingSettings())?->{$setting};
    }

    public function getAppFee()
    {
        return self::getBillingSetting('application_fee_percent') ?? config('billing.team_member_subscriptions.application_fee_percent');
    }

    public static function isUsingUserSubscriptions()
    {
        return self::hasBillingSettingEnabled('user_subscriptions');
    }

    public static function isUsingTeamSubscriptions()
    {
        return self::hasBillingSettingEnabled('team_subscriptions');
    }

    public static function isUsingTeamMemberSubscriptions()
    {
        return self::hasBillingSettingEnabled('team_member_subscriptions');
    }

    public static function isUsingPaymentGateway($gateway) : bool
    {
        return (new BillingSettings())->payment_gateway == $gateway;
    }

    public static function isUsingStripe() : bool
    {
        return self::isUsingPaymentGateway('stripe');
    }

    public static function isUsingChargent() : bool
    {
        return self::isUsingPaymentGateway('chargent');
    }

    public static function isAllowingGuestAccess() : bool
    {
        return (new GeneralSettings)->allow_guest_access;
    }

    public static function shouldShowLoginOnGuestAccess() : bool
    {
        return (new GeneralSettings)->should_show_login_on_guest_access;
    }

    public static function isSubscriptionShownInNavigation()
    {
        return self::getBillingSetting('show_user_subscription_plan_in_navigation');
    }

    public static function isSubscriptionShownInProfileHeader()
    {
        return self::getBillingSetting('show_user_subscription_plan_in_profile_header');
    }
}
