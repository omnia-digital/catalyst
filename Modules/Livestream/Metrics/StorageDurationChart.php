<?php

namespace Modules\Livestream\Metrics;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Livestream\Metrics\MetricTypes\Chart;
use Modules\Livestream\Models\Episode;
use Modules\Livestream\Models\ExtraInvoiceItem;

class StorageDurationChart extends Chart
{
    public function calculate(Carbon $from, Carbon $to): Collection|EloquentCollection
    {
        $team = auth()->user()->currentTeam;

        // Normal Episodes
        $durationInSeconds = $team->livestreamAccount
            ->episodes()
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get([
                DB::raw('Date(created_at) as date'),
                DB::raw('SUM(duration / 1000 / 60) as "value"'),
            ]);

        // Deleted Episodes
        $extraInvoiceDurationInSeconds = $team
            ->extraInvoiceItems()
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get([
                DB::raw('Date(created_at) as date'),
                DB::raw('SUM(duration / 1000 / 60) as "value"'),
            ]);

        // We need to sum values if the item in 2 collections have same date.
        $sumTwoDurations = $durationInSeconds->map(function (Episode $episode) use ($extraInvoiceDurationInSeconds) {
            $extraDuration = $extraInvoiceDurationInSeconds->where('date', $episode['date'])->first();
            $duration = ($extraDuration['value'] ?? 0) + $episode['value'];

            return [
                'date' => $episode['date'],
                'value' => round($duration),
            ];
        });

        // Then, we need to get the durations that not sum from extra invoice items.
        $notSumDurations = $extraInvoiceDurationInSeconds->map(function (ExtraInvoiceItem $extraInvoiceItem) use ($sumTwoDurations) {
            $alreadySum = $sumTwoDurations->where('date', $extraInvoiceItem['date'])->first();

            return $alreadySum ? null : [
                'date' => $extraInvoiceItem['date'],
                'value' => round($extraInvoiceItem['value']),
            ];
        })->filter();

        // Finally, merge sum and not sum together.
        return $sumTwoDurations->mergeRecursive($notSumDurations);
    }

    public function cacheFor()
    {
        //return now()->addMinutes(5);
    }
}
