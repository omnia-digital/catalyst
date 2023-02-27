<?php namespace App\Jobs\Streams;

use App\Models\Stream;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class EnableStreamJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Stream $stream) {}

    public function handle()
    {
        if ($this->stream->isActive()) {
            return;
        }

        $this->stream->enable();
    }
}
