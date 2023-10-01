<?php

namespace Modules\Jobs\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use OptimistDigital\NovaSettings\NovaSettings;
use Vyuldashev\NovaPermission\NovaPermissionTool;

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
            $this->setUserTimezone();
            $this->setLocale();
        });

        Nova::sortResourcesBy(function ($resource) {
            return $resource::$priority ?? 9999;
        });

        NovaSettings::addSettingsFields([
            Currency::make('JobPosition Posting Price', 'job:posting_price')
                ->rules('required'),

            Number::make('Featured Days', 'job:featured_days')
                ->help('How long do featured jobs stay up? Default is 30 days')
                ->rules('nullable', 'integer', 'min:1'),

            Number::make('Featured Jobs Limit', 'job:featured_jobs_limit')
                ->help('How many featured jobs should be shown? Leave blank or enter 0 to show unlimited.')
                ->rules('nullable', 'integer', 'min:0'),
        ], [], 'JobPosition');
    }

    /**
     * Set timezone for the application.
     */
    private function setUserTimezone(): void
    {
        Nova::userTimezone(function () {
            return 'UTC';
        });
    }

    /**
     * Set locate for the application.
     */
    private function setLocale(): void
    {
        App::setLocale(config('app.locale'));
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            NovaSettings::make(),

            NovaPermissionTool::make(),
        ];
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
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
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
        Gate::define('viewNova', function ($user) {
            return $user->hasRole('Admin');
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
