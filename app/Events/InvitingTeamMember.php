<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class InvitingTeamMember extends BaseEvent
{
    use Dispatchable;

    /**
     * The team instance.
     *
     * @var mixed
     */
    public $team;

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
     * The message from the inviter.
     *
     * @var mixed
     */
    public $message;

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
