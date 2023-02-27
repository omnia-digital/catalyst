<?php namespace App\Plans;

use App\Plans\Features\Feature;

trait HasPlan
{
    /**
     * Check if the current billable
     * has reached to the limit of the plan's feature.
     *
     * @param string $feature
     * @return bool
     */
    public function hasReachedLimit(string $feature): bool
    {
        /** @var Feature $featureClass */
        $featureClass = app($feature);

        if (!$featureClass instanceof Feature) {
            throw new \Exception("$feature must be an instance of " . Feature::class . ' abstract class.');
        }

        $plan = $this->sparkPlan();

        // If billable doesn't have plan, probably he is on the trial.
        if (!$plan) {
            // This feature doesn't allow trial plan to use it.
            if (!$featureClass->isAvailableOnTrial) {
                return true;
            }

            // Determine if this feature limit how many resources on trial.
            // If not, always return false. Otherwise, check if billable reach the limit of trial plan.
            $maxResourcesOnTrial = $featureClass->maxResourcesOnTrial;

            return !is_null($maxResourcesOnTrial) && $featureClass->usage() >= $maxResourcesOnTrial;
        }

        return $featureClass->usage() >= $plan->options[$feature] ?? 0;
    }

    /**
     * Get the price of a metered item.
     *
     * @param string $metered
     * @return int|float
     */
    public function meteredPrice(string $metered): int|float
    {
        $plan = $this->sparkPlan();

        // Free plan
        if (!$plan) {
            return 0;
        }

        $price = config("metered.price.plans.$plan->id.$metered");

        if (is_null($price)) {
            throw new \Exception('Cannot find metered price (' . $metered . ') for plan: ' . $plan->id);
        }

        return $price;
    }
}
