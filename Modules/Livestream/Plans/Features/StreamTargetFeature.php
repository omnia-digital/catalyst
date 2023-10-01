<?php

namespace Modules\Livestream\Plans\Features;

class StreamTargetFeature extends Feature
{
    /**
     * Determine if this feature is available on trial plan.
     */
    public bool $isAvailableOnTrial = true;

    public ?int $maxResourcesOnTrial = 2;

    /**
     * Count the stream target usage of the current livestream account.
     */
    public function usage(): int
    {
        return $this->livestreamAccount()->streamTargets()->count();
    }
}
