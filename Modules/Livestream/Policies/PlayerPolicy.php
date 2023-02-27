<?php namespace App\Policies;

use App\Models\Player;
use App\Models\User;
use App\Policies\Traits\HasDefaultPolicy;

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
