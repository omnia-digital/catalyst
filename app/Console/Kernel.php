<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\Billing\Jobs\SyncChargentSubscriptionStatuses;
use Modules\Forms\Jobs\SendFormNotificationsJob;
use Platform;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->job(new SyncChargentSubscriptionStatuses)
            ->dailyAt('22:00');

        $schedule->job(new SendFormNotificationsJob)
            ->everyThirtyMinutes()
            ->when(fn () => Platform::isModuleEnabled('forms'));

        $schedule->command('backup:clean')->daily()->at('01:00');
        $schedule->command('backup:run')->daily()->at('02:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
