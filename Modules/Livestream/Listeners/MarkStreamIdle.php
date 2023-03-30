<?php

namespace Modules\Livestream\Listeners;

use Exception;
use Modules\Livestream\Events\StreamIdle;
use Modules\Livestream\Models\Stream;

class MarkStreamIdle
{
    public function handle(StreamIdle $event)
    {
        $stream = Stream::where('stream_id', $event->data['object']['id'])->first();

        if (empty($stream)) {
            throw new Exception('Could not find Stream ' . $event->data['stream_id']);
        }

        $stream->markAsIdle();
    }
}
