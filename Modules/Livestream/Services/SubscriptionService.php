<?php

namespace Modules\Livestream\Services;

use Illuminate\Support\Collection;
use Laravel\Cashier\Billable;
use Laravel\Spark\Contracts\Interactions\Subscribe;
use Laravel\Spark\Contracts\Interactions\SubscribeTeam;
use Laravel\Spark\Plan;
use Laravel\Spark\TeamPlan;
use Modules\Livestream\Omnia;
use Modules\Livestream\Team;
use Modules\Livestream\User;

class SubscriptionService extends Service
{
    /**
     * Subscribe billable entity to Plan
     *
     * @param  Billable  $billable
     * @return mixed
     */
    public function subscribeToPlan($billable, Plan $plan, array $data)
    {
        if ($billable instanceof Team) {
            $subscribeInteraction = SubscribeTeam::class;
        } elseif ($billable instanceof User) {
            $subscribeInteraction = Subscribe::class;
        }

        return Omnia::interact(
            $subscribeInteraction, [
                $billable,
                $plan,
                false,
                $data,
            ]);
    }

    /**
     * Retrieve Plans from data, then Subscribe Billbable entity to given plans
     *
     * @param  Billable  $billable Can be any billable entity such as Team or User
     * @return Collection
     */
    public function subscribeToPlans(Collection $plans, $billable, array $data)
    {
        if (is_array($plans)) {
            $plans = collect($plans);
        } elseif (! $plans instanceof Collection) {
            throw new Exception('$data parameter must be a Request, array or Collection');
        }
        $response = collect();

        // Go through each of the plans and subscribe the billable entities to the necessary plans
        foreach ($plans as $plan) {
            if ($plan instanceof TeamPlan) {
                if ($billable instanceof User) {
                    $response->push($this->subscribeToPlan($billable->currentTeam(), $plan, $data));
                } elseif ($billable instanceof Team) {
                    $response->push($this->subscribeToPlan($billable, $plan, $data));
                }
            } elseif ($plan instanceof Plan) {
                if ($billable instanceof User) {
                    $response->push($this->subscribeToPlan($billable, $plan, $data));
                } elseif ($billable instanceof Team) {
                    throw new Exception('Given User Plan but billable entity is a Team so we will not subscribe the team to a user plan.');
                }
            }
        }

        return $response;
    }
}
