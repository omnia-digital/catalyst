<?php

namespace Modules\Livestream\Events;

use Illuminate\Contracts\Auth\Authenticatable;

class FirstTimeLogin
{
    /**
     * The user instance.
     *
     * @var Authenticatable
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param Authenticatable $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}
