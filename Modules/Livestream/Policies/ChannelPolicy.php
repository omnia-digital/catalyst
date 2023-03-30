<?php

namespace Modules\Livestream\Policies;

use Modules\Livestream\Models\Channel;
use Modules\Livestream\Models\User;
use Modules\Livestream\Policies\Traits\HasDefaultPolicy;

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
