<?php

namespace Modules\Livestream\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Modules\Livestream\Models\Team;
use Spark\Plan;
use Spark\Spark;

class SparkServiceProvider extends ServiceProvider
{
    public function register()
    {
        Spark::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Resolve the current team
        Spark::billable(Team::class)->resolve(function (Request $request) {
            return $request->user()->currentTeam;
        });

        // Verify that the current user owns the team
        Spark::billable(Team::class)->authorize(function (Team $billable, Request $request) {
            return $request->user() &&
                $request->user()->belongsToTeam($billable);
//                   $request->user()->id == $billable->user_id;
        });

        Spark::billable(Team::class)->checkPlanEligibility(function (Team $billable, Plan $plan) {
            // if ($billable->projects > 5 && $plan->name == 'Basic') {
            //     throw ValidationException::withMessages([
            //         'plan' => 'You have too many projects for the selected plan.'
            //     ]);
            // }
        });
    }
}
