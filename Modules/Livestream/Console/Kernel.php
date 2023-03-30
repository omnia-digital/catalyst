<?php

namespace Modules\Livestream\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Episode expiration
        $schedule->command('episodes:soft-delete')->dailyAt('1:00');
//        $schedule->command('episodes:force-delete')->weekly();

        // Stream
//        $schedule->command('stream:disable')->daily();

        // Pull views from Mux
        $schedule->command('episodes:pull-views')->cron('0 */' . config('omnia.pull_views_per_hours') . ' * * *');
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
