<?php namespace Modules\Livestream\Metrics;

use Modules\Livestream\Actions\Episodes\GetStorageDurationAction;
use Modules\Livestream\Metrics\MetricTypes\Value;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CurrentStorageCost extends Value
{
    /**
     * @param Carbon $from
     * @param Carbon $to
     * @return int|float
     */
    public function calculate(Carbon $from, Carbon $to): int|float
    {
        $duration = (new GetStorageDurationAction)->execute($from, $to);

        return round($duration * Auth::user()->currentTeam->meteredPrice('storage'), 2);
    }
}
