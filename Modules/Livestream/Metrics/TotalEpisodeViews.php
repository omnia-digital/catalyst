<?php namespace App\Metrics;

use App\Actions\Episodes\GetTotalEpisodeViewsAction;
use App\Metrics\MetricTypes\Value;
use App\Services\Mux\MuxVideoView;
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
