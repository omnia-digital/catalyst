<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class InvitingTeamMember
{
    use Dispatchable;

    /**
     * The email address of the invitee.
     *
     * @var mixed
     */
    public $email;

    /**
     * The role of the invitee.
     *
     * @var mixed
     */
    public $role;

    /**
     * Create a new event instance.
     *
     * @param  mixed  $team
     * @param  mixed  $email
     * @param  mixed  $role
     * @param  mixed  $message
     * @return void
     */
    public function __construct($team, $email, $role, $message)
    {
        $this->team = $team;
        $this->email = $email;
        $this->role = $role;
        $this->message = $message;
    }
}
