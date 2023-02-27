<?php namespace App\Metrics;

use App\Actions\Series\GetMostViewedSeriesAction;
use App\Metrics\MetricTypes\ObjectModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MostViewedSeries extends ObjectModel
{
    /**
     * @param Carbon $from
     * @param Carbon $to
     * @return Model
     */
    public function calculate(Carbon $from, Carbon $to): Model|null
    {
        return (new GetMostViewedSeriesAction())->execute($from, $to, false);
    }
}
