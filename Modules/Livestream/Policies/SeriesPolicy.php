<?php

namespace Modules\Livestream\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Livestream\Models\Series;
use Modules\Livestream\Models\User;

class SeriesPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Series $series)
    {
        return $user->currentTeam->livestreamAccount->id === $series->livestream_account_id;
    }

    public function delete(User $user, Series $series)
    {
        return $user->currentTeam->livestreamAccount->id === $series->livestream_account_id;
    }
}
