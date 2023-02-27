<?php namespace Modules\Livestream\Events;

use Illuminate\Foundation\Events\Dispatchable;

class StreamActive
{
    use Dispatchable;

    public function __construct(public array $data) {}
}
