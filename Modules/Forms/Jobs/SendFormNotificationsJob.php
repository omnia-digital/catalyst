<?php

namespace Modules\Forms\Jobs;

use App\Models\Team;
use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Forms\Models\FormNotification;
use Modules\Forms\Notifications\FormReminderNotification;

class SendFormNotificationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        collect($this->whereMidnight())->each(function ($date, $tz) {
            FormNotification::whereDate('send_date', $date)
                ->where('timezone', $tz)
                ->each(fn ($formNotification) => $this->send($formNotification));
        });
    }

    /**
     * Get the name of the timezones (if any) where it is currently midnight.
     *
     * @return string
     */
    private function whereMidnight()
    {
        return collect(CarbonTimeZone::listIdentifiers())
            ->filter(function ($name) {
                return Carbon::now($name)->setSeconds(0)->isMidnight();
            })->flatMap(function ($tz) {
                return [$tz => Carbon::now($tz)->startOfDay()->toDateTimeString()];
            });
    }

    /**
     * Send the given formNotification to required users.
     *
     * @return void
     */
    private function send(FormNotification $formNotification)
    {
        $team = Team::findOrFail($formNotification->form->team_id);

        $team->members()->where('role', $formNotification->role->name)
            ->each(function ($user) use ($team, $formNotification) {
                $user->notify(new FormReminderNotification($team, $formNotification));
            });
    }
}
