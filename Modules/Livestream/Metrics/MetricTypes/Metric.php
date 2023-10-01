<?php

namespace Modules\Livestream\Metrics\MetricTypes;

use Carbon\Carbon;
use DateInterval;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Modules\Livestream\Metrics\TimeFilters\TimeFilterRegistry;

abstract class Metric
{
    public static bool $previous = false;

    /**
     * Calculate for the previous period.
     *
     * @return static
     */
    public static function previous(bool $previous = true): self
    {
        static::$previous = $previous;

        return new static;
    }

    /**
     * @return Collection
     */
    public static function make(string $timeFilter)
    {
        $timeFilterClass = app(TimeFilterRegistry::class)->get($timeFilter);

        $from = static::$previous ? $timeFilterClass->previousFrom() : $timeFilterClass->from();
        $to = static::$previous ? $timeFilterClass->from() : $timeFilterClass->to();

        // Reset previous flag to default,
        // so other charts can get the right time filter.
        static::$previous = false;

        return (new static)->resolve($from, $to, $timeFilter);
    }

    /**
     * @return Collection|mixed
     */
    protected function resolve(Carbon $from, Carbon $to, string $timeFilter)
    {
        $resolver = function () use ($from, $to) {
            return method_exists($this, 'calculate') ? $this->calculate($from, $to) : null;
        };

        if ($cacheFor = $this->cacheFor()) {
            $cacheFor = is_numeric($cacheFor) ? new DateInterval(sprintf('PT%dS', $cacheFor * 60)) : $cacheFor;

            return Cache::remember(
                $this->getCacheKey($timeFilter),
                $cacheFor,
                $resolver
            );
        }

        return $resolver();
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  DateTimeInterface|DateInterval|float|int|null|void
     */
    public function cacheFor()
    {
    }

    /**
     * Get the appropriate cache key for the metric.
     */
    protected function getCacheKey(string $timeFilter): string
    {
        return sprintf(
            'omnia.metric.%s.%s.%s.%s',
            get_class($this),
            auth()->user()->currentTeam->id,
            $timeFilter,
            static::$previous ? 'previous' : 'current'
        );
    }
}
