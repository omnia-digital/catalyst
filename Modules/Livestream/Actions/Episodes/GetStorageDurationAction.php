<?php

namespace Modules\Livestream\Actions\Episodes;

use Carbon\Carbon;
use Modules\Livestream\Models\Team;

class GetStorageDurationAction
{
    public function execute(Carbon $from, Carbon $to, bool $expiredOnly = true, ?Team $team = null): int|float
    {
        is_null($team) && $team = auth()->user()->currentTeam;

        // For normal episodes, get all episodes to calculate the storage duration.
        if ($expiredOnly) {
            $durationInMilliSeconds = $team->livestreamAccount->episodes()->expired()->sum('duration');
        } else {
            $durationInMilliSeconds = $team->livestreamAccount->episodes()->sum('duration');
        }

        // For deleted episodes, only get episodes in the period time to calculate the storage duration.
        $extraInvoiceDurationInMilliSeconds = $team->extraInvoiceItems()
            ->whereBetween('created_at', [$from, $to])
            ->sum('duration');

        // Duration in seconds.
        $duration = ($durationInMilliSeconds + $extraInvoiceDurationInMilliSeconds) / 1000;

        // Convert duration to minutes if unit type is minute.
        if (config('metered.price.unit') === 'minute') {
            $duration = $duration / 60;
        }

        return $duration;
    }
}
