<?php

namespace App\Contracts;

interface InvitesTeamMembers
{
    /**
     * Invite a new team member to the given team.
     *
     * @param  mixed  $user
     * @param  mixed  $team
     * @param  string  $email
     * @param  string  $message
     * @return void
     */
    public function invite($user, $team, string $email, string $role = null, string $message = '');
}