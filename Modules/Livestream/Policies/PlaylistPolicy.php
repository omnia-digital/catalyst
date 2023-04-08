<?php

namespace Modules\Livestream\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Livestream\Models\Playlist;
use Modules\Livestream\Models\User;

class PlaylistPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Playlist $playlist)
    {
        return $user->currentTeam->livestreamAccount->id === $playlist->livestream_account_id;
    }

    public function delete(User $user, Playlist $playlist)
    {
        return $user->currentTeam->livestreamAccount->id === $playlist->livestream_account_id;
    }
}
