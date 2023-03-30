<?php

namespace Modules\Livestream\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Modules\Livestream\Models\LivestreamAccount;
use Modules\Livestream\Models\Series;
use Modules\Livestream\Models\Stream;
use Modules\Livestream\Models\User;
use Modules\Livestream\Nova\Policies\NovaLivestreamAccountPolicy;
use Modules\Livestream\Nova\Policies\NovaStreamPolicy;
use Modules\Livestream\Policies\NovaSeriesPolicy;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::serving(function () {
            Gate::policy(Stream::class, NovaStreamPolicy::class);
            Gate::policy(LivestreamAccount::class, NovaLivestreamAccountPolicy::class);
            Gate::policy(Series::class, NovaSeriesPolicy::class);
        });
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Nova::report(function ($exception) {
            if (app()->bound('sentry')) {
                app('sentry')->captureException($exception);
            }
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function (User $user) {
            return $user->isAdmin();
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            new Help,
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [];
    }
}
