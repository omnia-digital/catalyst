<?php

namespace Modules\Livestream\Metrics;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Modules\Livestream\Metrics\MetricTypes\Chart;
use Modules\Livestream\Services\Mux\MuxVideoView;

class TotalVideoViewsByLivestreamAccountChart extends Chart
{
    public function calculate(Carbon $from, Carbon $to): Collection|EloquentCollection
    {
        $team = auth()->user()->currentTeam;

        return app(MuxVideoView::class)->getViews(
            livestreamAccount: $team->livestreamAccount,
            from: $from,
            to: $to
        );
    }

    public function cacheFor()
    {
        //return now()->addMinutes(5);
    }
}
