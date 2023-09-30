<?php

namespace Modules\Livestream\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Modules\Livestream\Metrics\TimeFilters\AllTimeFilter;
use Modules\Livestream\Metrics\TimeFilters\LastMonthTimeFilter;
use Modules\Livestream\Metrics\TimeFilters\LastSevenDaysTimeFilter;
use Modules\Livestream\Metrics\TimeFilters\LastSixMonthsTimeFilter;
use Modules\Livestream\Metrics\TimeFilters\LastThirtyDaysTimeFilter;
use Modules\Livestream\Metrics\TimeFilters\ThisMonthTimeFilter;
use Modules\Livestream\Metrics\TimeFilters\ThisYearTimeFilter;
use Modules\Livestream\Metrics\TimeFilters\TimeFilterRegistry;
use Modules\Livestream\Metrics\TimeFilters\TodayTimeFilter;

class MetricTimeFilterServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Boot services.
     */
    public function boot()
    {
        $this->app->make(TimeFilterRegistry::class)
            ->register('today', new TodayTimeFilter)
            ->register('7-days', new LastSevenDaysTimeFilter)
            ->register('30-days', new LastThirtyDaysTimeFilter)
            ->register('last-month', new LastMonthTimeFilter)
            ->register('6-months', new LastSixMonthsTimeFilter)
            ->register('this-month', new ThisMonthTimeFilter)
            ->register('this-year', new ThisYearTimeFilter)
            ->register('all-time', new AllTimeFilter);
    }

    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(TimeFilterRegistry::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            TimeFilterRegistry::class,
        ];
    }
}
