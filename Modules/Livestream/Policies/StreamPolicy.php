<?php namespace Modules\Livestream\Policies;

use Modules\Livestream\Models\Stream;
use Modules\Livestream\Models\User;
use Modules\Livestream\Policies\Traits\HasDefaultPolicy;

class StreamPolicy
{
    use HasDefaultPolicy;

    public function view(User $user, Stream $stream)
    {
        return $stream->livestream_account_id === $user->currentTeam->livestreamAccount->id;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, Stream $stream)
    {
        return $stream->livestream_account_id === $user->currentTeam->livestreamAccount->id;
    }

    public function delete(User $user, Stream $stream)
    {
        return false;
    }

}
