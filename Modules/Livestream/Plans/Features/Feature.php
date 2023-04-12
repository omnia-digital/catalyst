<?php

namespace Modules\Livestream\Plans\Features;

use Closure;
use Modules\Livestream\Models\LivestreamAccount;
use Modules\Livestream\Models\Team;

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
     */
    public function billable(): Team
    {
        return auth()->user()->currentTeam;
    }

    /**
     * Get the default livestream account.
     */
    public function livestreamAccount(): LivestreamAccount
    {
        return auth()->user()->currentTeam->livestreamAccount;
    }

    /**
     * Set feature is available on trial.
     */
    public function isAvailableOnTrial(Closure $callback)
    {
        $this->isAvailableOnTrial = $callback();
    }

    abstract public function usage(): int;
}
