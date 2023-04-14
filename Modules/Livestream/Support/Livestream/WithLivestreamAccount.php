<?php

namespace Modules\Livestream\Support\Livestream;

trait WithLivestreamAccount
{
    public function getLivestreamAccountProperty()
    {
        return auth()->user()->currentTeam->livestreamAccount;
    }
}
