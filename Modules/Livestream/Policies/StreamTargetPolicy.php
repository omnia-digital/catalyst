<?php namespace Modules\Livestream\Policies;

use Modules\Livestream\Models\StreamTarget;
use Modules\Livestream\Models\User;
use Modules\Livestream\Policies\Traits\HasDefaultPolicy;

class StreamTargetPolicy
{
    use HasDefaultPolicy;

    public function view(User $user, StreamTarget $streamTarget)
    {
        return false;
    }

    public function update(User $user, StreamTarget $streamTarget)
    {
        return $streamTarget->stream->livestreamAccount->id === $user->currentTeam->livestreamAccount->id;
    }

    public function delete(User $user, StreamTarget $streamTarget)
    {
        return $streamTarget->stream->livestreamAccount->id === $user->currentTeam->livestreamAccount->id;
    }
}
