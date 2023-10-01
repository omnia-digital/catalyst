<?php

namespace Modules\Livestream\Configuration;

use Exception;
use Illuminate\Support\Collection;
use Laravel\Spark\Plan;
use Laravel\Spark\Spark;
use Modules\Livestream\Omnia;

trait ManagesAvailablePlans
{
    /**
     * @param  int|string  $id Searches by the Id of the plan
     * @param  bool  $teamPlans get Team Plans or user Plans
     * @return Plan
     *
     * @throws Exception
     */
    public static function getPlanById($id, $teamPlans = false)
    {
        if ($teamPlans === false) {
            $plans = Omnia::plans();
        } else {
            $plans = Omnia::teamPlans();
        }
        $plan = $plans->where('id', $id)->first();

        if (empty($plan)) {
            throw new Exception('Could not find that plan by identifier: ' . $id);
        } else {
            return $plan;
        }
    }

    /**
     * Get the Default Plan for the given module
     *
     * @return string
     */
    public static function getRequiredPlanIdsForModule($module)
    {
        $plans = collect();

        switch ($module) {
            case 'livestream':
//                $plans->push('livestream-metered');
                break;
        }
//        $plans->push('omnia-metered');

        return $plans;
    }

    /**
     * Retrieve All Plans
     *
     * @param  bool  $hidden Hides Plans by defualt that have attribute 'hidden' = true
     * @return Collection|static
     */
    public static function allPlans($hidden = false)
    {
        $allPlans = Spark::allPlans();
        if ($hidden === true) {
            $allPlans = $allPlans->reject(function ($value, $key) {
                if (empty($value->attributes['hidden'])) {
                    $reject = false;
                } elseif ($value->attributes['hidden'] === true) {
                    $reject = true;
                }

                return $reject;
            });
        }

        return $allPlans;
    }

    /**
     * Setup Available Plans for Omnia
     */
    public static function setupAvailablePlans()
    {
        self::createUserPlans();
        self::createTeamPlans();

        //** Hidden Plans **//
        // Omnia Metered Plan (this is a catch-all for metered billing for all Omnia plans to prevent having a ton of different invoices each month)
        $meteredPlanFeatures = collect();
        $meteredPlanAttributes = collect([
            'module' => 'omnia',
            'hidden' => true,
        ]);
        self::_createPlan('Omnia Metered', 'omnia-metered', 0, $meteredPlanFeatures, $meteredPlanAttributes, false);
    }

    public static function createUserPlans()
    {
        ///** User Billing Plans **///
        // Trial
        //	    Spark::trialDays();
        // Free Plan
//        Spark::freePlan('User Free Plan','user-free')
//            ->maxTeams(1);
    }

    /**
     * Create the Team Plans for the application
     */
    public static function createTeamPlans()
    {
        // Trial
        Spark::teamTrialDays(7);
        self::createLivestreamPlans();
    }

    /**
     * Get the Livestream module plans
     */
    public static function createLivestreamPlans()
    {
        //	    'tachometer'    => 'Admin Dashboard',
        //		        'bar-chart'     => 'Livestream Stats Dashboard',
        //	        	'youtube-play'  => 'Live player embed on your website',
        ////		        'hdd-o'         => '5GB Video Usage Included *',
        //		        'power-off'     => 'Video on Demand Archive so people can watch whenever they want',
        //		        'headphones'    => 'Audio-only or Video Podcasts',
        //		        'tablet'        => 'Complete Responsive design so it works on every device',
        //		        'globe'         => 'Dedicated landing page site with online Bible',
        //	    'rss'           => 'RSS feed to integrate with other apps or services',
        //	    		         'youtube'          => 'Youtube Integration',

        ///** Livestream Team Billing Plans **///
        ////** Free Plan **//
        $freePlanFeatures = collect([
            'user' => 'Max Team Members: 1',
            'video-camera' => 'Live playback only',
        ]);
        $freePlanAttributes = collect([
            'module' => 'livestream',
            'max-team-members' => 1,
        ]);
        self::_createPlan('Forever Free', 'livestream-free', 0, $freePlanFeatures, $freePlanAttributes, false);

        ///*** Archived Plans ***///
        //** Basic Plan **//
        $basicPlanFeatures = collect([
            'video-camera' => 'Livestream + Unlimited Episodes',
            'life-ring' => 'Phone Support',
        ]);
        $basicPlanAttributes = collect([
            'module' => 'livestream',
            'max-team-members' => 5,
            'video-storage-rate' => .12,
        ]);
        self::_createPlan('Basic', 'livestream-basic', 14, $basicPlanFeatures, $basicPlanAttributes, true, 11, null,
            true);

        //** Standard Plan **//
        $standardPlanFeatures = collect([
            'facebook-square' => 'Facebook Live Streaming',
            'life-ring' => 'Priority Support',
        ]);
        $standardPlanAttributes = collect([
            'module' => 'livestream',
            'video-storage-rate' => .10,
        ]);
        self::_createPlan('Standard', 'livestream-standard', 49, $standardPlanFeatures, $standardPlanAttributes, true,
            11, null, true);

        //** Premium Plan **//
        $premiumPlanFeatures = collect([
            'globe' => 'Worldwide CDN',
            'life-ring' => 'Personal Technician (Live Chat, Email, Phone)',
        ]);
        $premiumPlanAttributes = collect([
            'module' => 'livestream',
            'video-storage-rate' => .08,
        ]);
        self::_createPlan('Premium', 'livestream-premium', 99, $premiumPlanFeatures, $premiumPlanAttributes, true, 11,
            null, true);
        ///*** FINISH Archived Plans ***///

        //** Starter Plan **//
        $standardPlanFeatures = collect([
            'facebook-square' => 'Facebook Live Streaming',
            'life-ring' => 'Priority Support',
        ]);
        $standardPlanAttributes = collect([
            'module' => 'livestream',
            'video-storage-rate' => .10,
        ]);
        self::_createPlan('Starter', 'livestream-starter', 59, $standardPlanFeatures, $standardPlanAttributes, true,
            null, 588, false);

        //** Growth Plan **//
        $premiumPlanFeatures = collect([
            'globe' => 'Worldwide CDN',
            'life-ring' => 'Personal Technician (Live Chat, Email, Phone)',
        ]);
        $premiumPlanAttributes = collect([
            'module' => 'livestream',
        ]);
        self::_createPlan('Growth', 'livestream-growth', 119, $premiumPlanFeatures, $premiumPlanAttributes, true, null,
            1188, false);
    }

    /**
     * @param  string  $planName Name of the plan that is shown to the user
     * @param  string  $planId Billing id of plan used by Stripe/Braintree, etc.
     * @param  int  $price Price of the plan
     * @param  Collection  $features These are items that will be shown to users
     * @param  Collection  $attributes These are application-level limitations and calculations used for each plan
     * @param  bool  $makeYearPlan Whether or not to create the Year Plan as well
     * @param  int|string  $yearMultiplier The amount of months to charge for on the Year Plan (this is a discount
     *                                      given to encourage users/teams to upgrade to yearly plans)
     */
    private static function _createPlan(
        $planName,
        $planId,
        $price,
        Collection $features,
        Collection $attributes,
        $makeYearPlan = true,
        $yearMultiplier = 11,
        $yearPrice = null,
        $archived = false
    ) {
        // @TODO [Josh] - need to put this into the cache to speed up requests since this happens on every spark reload
        $plan = Spark::teamPlan($planName, $planId);
        $plan->price($price);
        // Features
        if ($features->isNotEmpty()) {
            $plan->features($features->all());
        }
        // Attributes
        if ($attributes->isNotEmpty()) {
            $plan->attributes($attributes->all());
        }
        // Team Members
        if (! empty($attributes->has('max-team-members'))) {
            $plan->maxTeamMembers($attributes->get('max-team-members'));
        }

        // Archived Plans
        if ($archived === true) {
            $plan->archived();
        }

        if ($makeYearPlan === true) {
            $yrPlan = Spark::teamPlan($planName, $planId . '-yr');
            if (! is_null($yearMultiplier)) {
                $yrPlan->price($price * $yearMultiplier);
            } elseif (! is_null($yearPrice)) {
                $yrPlan->price($yearPrice);
            }
            $yrPlan->yearly();
            // Team Members
            if (! empty($maxTeamMembers)) {
                $yrPlan->maxTeamMembers($attributes->get('max-team-members'));
            }
            // Features
            if ($features->isNotEmpty()) {
                $yrPlan->features($features->all());
            }
            // Attributes
            if ($attributes->isNotEmpty()) {
                $yrPlan->attributes($attributes->all());
            }
            // Archived Plans
            if ($archived === true) {
                $yrPlan->archived();
            }
        }
    }
}
