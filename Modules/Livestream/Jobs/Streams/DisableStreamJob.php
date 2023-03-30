<?php

namespace Modules\Livestream\Jobs\Streams;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Livestream\Models\Stream;

class DisableStreamJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Stream $stream)
    {
    }

    public function handle()
    {
        if ($this->stream->isDisabled()) {
            return;
        }

        $this->stream->disable();
    }
}
