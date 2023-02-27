<?php namespace App\Policies;

use App\Models\Episode;
use App\Models\User;
use App\Policies\Traits\HasDefaultPolicy;

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
