<?php

namespace Modules\Livestream\Policies;

use Modules\Livestream\Models\Person;
use Modules\Livestream\Models\User;
use Modules\Livestream\Policies\Traits\HasDefaultPolicy;

class PersonPolicy
{
    use HasDefaultPolicy;

    public function view(User $user, Person $person)
    {
        return true;
        auth()->user()->isAdmin();

        // current user is an admin of a team that the person is a member of
        return $user->currentTeam->id === $person->livestream_account_id;
    }

    public function update(User $user, Person $person)
    {
        return true;

        return $user->currentTeam->livestreamAccount->id === $person->livestream_account_id;
    }

    public function delete(User $user, Person $person)
    {
        return true;

        return $user->currentTeam->livestreamAccount->id === $person->livestream_account_id;
    }
}
