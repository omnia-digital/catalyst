<?php namespace App\Metrics;

use App\Metrics\MetricTypes\Chart;
use App\Services\Mux\MuxVideoView;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class TotalVideoViewsByLivestreamAccountChart extends Chart
{
    public function calculate(Carbon $from, Carbon $to): Collection|EloquentCollection
    {
        $team = Auth::user()->currentTeam;

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
