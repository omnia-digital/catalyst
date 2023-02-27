<?php namespace App\Plans\Features;

use App\Models\LivestreamAccount;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;

abstract class Feature
{
    /**
     * Determine if this feature is available on trial plan.
     */
    public bool $isAvailableOnTrial = false;

    /**
     * Determine how many resources trial plan can has.
     */
    public ?int $maxResourcesOnTrial = null;

    /**
     * Get the current billable.
     *
     * @return Team
     */
    public function billable(): Team
    {
        return Auth::user()->currentTeam;
    }

    /**
     * Get the default livestream account.
     *
     * @return LivestreamAccount
     */
    public function livestreamAccount(): LivestreamAccount
    {
        return Auth::user()->currentTeam->livestreamAccount;
    }

    /**
     * Set feature is available on trial.
     *
     * @param \Closure $callback
     */
    public function isAvailableOnTrial(\Closure $callback)
    {
        $this->isAvailableOnTrial = $callback();
    }

    public abstract function usage(): int;
}
