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
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->job(new SyncChargentSubscriptionStatuses)
            ->dailyAt('22:00');

        $schedule->job(new SendFormNotificationsJob)
            ->everyThirtyMinutes()
            ->when(fn () => Platform::isModuleEnabled('forms'));

        $schedule->command('backup:clean')->daily()->at('01:00');
        $schedule->command('backup:run')->daily()->at('02:00');

        // Redis
        $schedule->command('cache:prune-stale-tags')->hourly();

        // Mailcoach
//        $schedule->command('mailcoach:send-automation-mails')->everyMinute();
//        $schedule->command('mailcoach:send-scheduled-campaigns')->everyMinute();
//        $schedule->command('mailcoach:send-campaign-mails')->everyMinute();
//
//        $schedule->command('mailcoach:run-automation-triggers')->everyMinute();
//        $schedule->command('mailcoach:run-automation-actions')->everyMinute();
//
//        $schedule->command('mailcoach:calculate-statistics')->everyMinute();
//        $schedule->command('mailcoach:calculate-automation-mail-statistics')->everyMinute();
//        $schedule->command('mailcoach:send-campaign-summary-mail')->hourly();
//        $schedule->command('mailcoach:cleanup-processed-feedback')->hourly();
//        $schedule->command('mailcoach:send-email-list-summary-mail')->mondays()->at('9:00');
//        $schedule->command('mailcoach:delete-old-unconfirmed-subscribers')->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
