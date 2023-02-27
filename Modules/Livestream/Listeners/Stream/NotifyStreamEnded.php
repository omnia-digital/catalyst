<?php

namespace Modules\Livestream\Listeners\Stream;

use Modules\Livestream\Omnia;
use Modules\Livestream\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Modules\Livestream\LivestreamAccount;
use Modules\Livestream\Notifications\StreamEnded;

/**
 * Class NotifyStreamEnded
 * @package App\Listeners\Episode
 */
class NotifyStreamEnded
{

    /**
     * Handle the event.
     * @param $event
     * @return bool
     * @throws \Exception
     */
    public function handle($event)
    {
        Log::info(__CLASS__ . '-[STARTED]');

        $notificationRequest = $event->notificationRequest;
        if (!empty($notificationRequest->LivestreamAccountId)) {
            $livestreamAccount = LivestreamAccount::find( $notificationRequest->LivestreamAccountId );
        }

        //** Send StreamEnded Notification to channels **//
        $message = 'Livestream Ended: (' . $livestreamAccount->team->id . ', ' . $livestreamAccount->id . ') ' . $livestreamAccount->team->name;
        $systemAdminUser = User::where('email',Omnia::$systemAdminUser)->first();
        $systemAdminUser->slack_webhook_url = env('SLACK_WEBHOOK_APP_URL');
        $systemAdminUser->notify(new StreamEnded($message));

        Log::info(__CLASS__ . '-[FINISHED]');
    }
}