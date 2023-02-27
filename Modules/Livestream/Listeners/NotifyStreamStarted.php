<?php namespace App\Listeners;

use App\Events\StreamActive;
use App\Models\Stream;
use App\Models\User;
use App\Notifications\LivestreamNotification;

class NotifyStreamStarted
{
    public function handle(StreamActive $event)
    {
        $stream = Stream::where('stream_id', $event->data['data']['id'])->first();

        if (!$stream) {
            throw new \Exception('Could not find stream with Stream ID: ' . $event['data']['id']);
        }

        $livestreamAccount = $stream->livestreamAccount;

        $message = 'Stream Started: '
            . $livestreamAccount->team->name
            . ' (' . $livestreamAccount->id
            . ', ' . $livestreamAccount->team->id
            . ', ' . $stream->stream_id . ')';

        User::admin()->get()->each(fn(User $user) => $user->notify(new LivestreamNotification($message)));
    }
}
