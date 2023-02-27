<?php namespace Modules\Livestream\Events;

use Illuminate\Foundation\Events\Dispatchable;

class StreamCompleted
{
    use Dispatchable;

    public function __construct(public array $data) {}
}
