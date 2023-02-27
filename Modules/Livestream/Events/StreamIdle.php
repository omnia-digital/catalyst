<?php namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class StreamIdle
{
    use Dispatchable;

    public function __construct(public array $data) {}
}
