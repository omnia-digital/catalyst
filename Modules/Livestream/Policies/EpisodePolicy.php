<?php

namespace Modules\Livestream\Policies;

use Modules\Livestream\Models\Episode;
use Modules\Livestream\Models\User;
use Modules\Livestream\Policies\Traits\HasDefaultPolicy;

class EpisodePolicy
{
    use HasDefaultPolicy;

    public function view(User $user, Episode $episode)
    {
        return $user->currentTeam->livestreamAccount->id === $episode->livestream_account_id;
    }

    public function update(User $user, Episode $episode)
    {
        return $user->currentTeam->livestreamAccount->id === $episode->livestream_account_id;
    }

    public function delete(User $user, Episode $episode)
    {
        return $user->currentTeam->livestreamAccount->id === $episode->livestream_account_id;
    }

    public function download(User $user, Episode $episode)
    {
        return $user->currentTeam->livestreamAccount->id === $episode->livestream_account_id;
    }
}
