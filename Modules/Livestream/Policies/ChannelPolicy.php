<?php namespace App\Policies;

use App\Models\Channel;
use App\Models\User;
use App\Policies\Traits\HasDefaultPolicy;

class ChannelPolicy
{
    use HasDefaultPolicy;

    public function update(User $user, Channel $channel)
    {
        return $user->currentTeam->livestreamAccount->id === $channel->livestream_account_id;
    }

    public function delete(User $user, Channel $channel)
    {
        return $user->currentTeam->livestreamAccount->id === $channel->livestream_account_id;
    }
}
