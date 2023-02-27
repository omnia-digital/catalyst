<?php namespace App\Providers;

use App\Metrics\TimeFilters\AllTimeFilter;
use App\Metrics\TimeFilters\LastMonthTimeFilter;
use App\Metrics\TimeFilters\LastSevenDaysTimeFilter;
use App\Metrics\TimeFilters\LastSixMonthsTimeFilter;
use App\Metrics\TimeFilters\LastThirtyDaysTimeFilter;
use App\Metrics\TimeFilters\ThisMonthTimeFilter;
use App\Metrics\TimeFilters\ThisYearTimeFilter;
use App\Metrics\TimeFilters\TimeFilterRegistry;
use App\Metrics\TimeFilters\TodayTimeFilter;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class MetricTimeFilterServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(TimeFilterRegistry::class);
    }

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
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            TimeFilterRegistry::class
        ];
    }
}
