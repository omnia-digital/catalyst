<?php namespace App\Actions\Episodes;

use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GetStorageDurationAction
{
    /**
     * @param Carbon $from
     * @param Carbon $to
     * @param Team|null $team
     * @return int|float
     */
    public function execute(Carbon $from, Carbon $to, bool $expiredOnly = true, ?Team $team = null): int|float
    {
        is_null($team) && $team = Auth::user()->currentTeam;

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
