<?php

namespace App\Listeners\Stream;

use App\Omnia;
use App\User;
use Illuminate\Support\Facades\Log;
use App\Notifications\StreamEnded;
use App\Stream;

/**
 * Class NotifyStreamStarted
 * @package App\Listeners\Episode
 */
class NotifyStreamStarted
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

        $message = 'Stream Started: ';

        $stream = Stream::where('stream_id','=',$event->stream_id)->first();
        if (empty($stream)) {
            $message .=  "Could not find stream";
        } else {
            $livestream_account = $stream->livestreamAccount;
            if (!empty($livestream_account)) {
                $message .= $livestream_account->team->name . ' (' . $livestream_account->id . ', ' . $livestream_account->team->id . ', ' . $stream->stream_id . ')';
            } else {
                $message .= $stream->stream_id . ': livestream account not found';
            }
        }

        //** Send StreamStart Notification to channels **//
        $systemAdminUser = User::where('email',Omnia::$systemAdminUser)->first();
        $systemAdminUser->slack_webhook_url = env('SLACK_WEBHOOK_APP_URL');
        $systemAdminUser->notify(new StreamEnded($message));

        Log::info(__CLASS__ . '-[FINISHED]');
    }
}
