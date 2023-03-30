<?php

namespace Modules\Livestream\Metrics;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\Livestream\Actions\Series\GetMostViewedSeriesAction;
use Modules\Livestream\Metrics\MetricTypes\ObjectModel;

class MostViewedSeries extends ObjectModel
{
    /**
     * @return Model
     */
    public function calculate(Carbon $from, Carbon $to): Model|null
    {
        return (new GetMostViewedSeriesAction)->execute($from, $to, false);
    }
}
