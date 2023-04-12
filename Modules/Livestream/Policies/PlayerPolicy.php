<?php

namespace Modules\Livestream\Policies;

use Modules\Livestream\Models\Player;
use Modules\Livestream\Models\User;
use Modules\Livestream\Policies\Traits\HasDefaultPolicy;

class PlayerPolicy
{
    use HasDefaultPolicy;

    public function view(User $user, Player $player)
    {
        return $user->currentTeam->livestreamAccount->id === $player->livestream_account_id;
    }

    public function update(User $user, Player $player)
    {
        return $user->currentTeam->livestreamAccount->id === $player->livestream_account_id;
    }

    public function delete(User $user, Player $player)
    {
        return $user->currentTeam->livestreamAccount->id === $player->livestream_account_id;
    }
}
