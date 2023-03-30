<?php namespace Modules\Livestream\Metrics;

use Modules\Livestream\Actions\Episodes\GetTotalEpisodeViewsAction;
use Modules\Livestream\Metrics\MetricTypes\Value;
use Modules\Livestream\Services\Mux\MuxVideoView;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TotalEpisodeViews extends Value
{
    /**
     * @param Carbon $from
     * @param Carbon $to
     * @return int|float
     */
    public function calculate(Carbon $from, Carbon $to): int|float
    {
        return (new GetTotalEpisodeViewsAction)->execute($from, $to, false);
    }
}
