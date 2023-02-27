<?php

namespace App\Policies;

use App\Models\Playlist;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

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
