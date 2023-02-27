<?php

namespace Modules\Livestream\Services;

use Modules\Livestream\Omnia;
use Modules\Livestream\Team;
use Modules\Livestream\User;
use Illuminate\Support\Collection;
use Laravel\Cashier\Billable;
use Laravel\Spark\Contracts\Interactions\Subscribe;
use Laravel\Spark\Contracts\Interactions\SubscribeTeam;
use Laravel\Spark\Plan;
use Laravel\Spark\TeamPlan;

class SubscriptionService extends Service
{
    /**
     * Subscribe billable entity to Plan
     *
     * @param Billable $billable
     * @param Plan $plan
     * @param array $data
     * @return mixed
     */
    public function subscribeToPlan($billable, Plan $plan, array $data)
    {
        if ($billable instanceof Team) {
            $subscribeInteraction = SubscribeTeam::class;
        } else if ($billable instanceof User) {
            $subscribeInteraction = Subscribe::class;
        }
        return Omnia::interact(
            $subscribeInteraction, [
            $billable,
            $plan,
            false,
            $data
        ]);
    }

    /**
     * Retrieve Plans from data, then Subscribe Billbable entity to given plans
     *
     * @param Collection $plans
     * @param Billable   $billable Can be any billable entity such as Team or User
     * @param array      $data
     *
     * @return Collection
     */
    public function subscribeToPlans(Collection $plans, $billable, array $data)
    {
        if (is_array($plans)) {
            $plans = collect($plans);
        } else if (!$plans instanceof Collection) {
            throw new Exception('$data parameter must be a Request, array or Collection');
        }
        $response = collect();

        // Go through each of the plans and subscribe the billable entities to the necessary plans
        foreach ($plans as $plan) {
            if ($plan instanceof TeamPlan) {
                if ($billable instanceof User) {
                    $response->push($this->subscribeToPlan($billable->currentTeam(), $plan, $data));
                } else if ($billable instanceof Team) {
                    $response->push($this->subscribeToPlan($billable, $plan, $data));
                }
            } else if ($plan instanceof Plan) {
                if ($billable instanceof User) {
                    $response->push($this->subscribeToPlan($billable, $plan, $data));
                } else if ($billable instanceof Team) {
                    throw new Exception('Given User Plan but billable entity is a Team so we will not subscribe the team to a user plan.');
                }
            }
        }

        return $response;
    }
}
