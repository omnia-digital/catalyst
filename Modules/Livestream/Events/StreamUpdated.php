<?php namespace Modules\Livestream\Events;

use Illuminate\Foundation\Events\Dispatchable;

class StreamUpdated
{
    use Dispatchable;

    public function __construct(public array $data) {}
}
