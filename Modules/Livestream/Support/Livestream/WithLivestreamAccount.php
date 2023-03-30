<?php namespace Modules\Livestream\Support\Livestream;

use Illuminate\Support\Facades\Auth;

trait WithLivestreamAccount
{
    public function getLivestreamAccountProperty()
    {
        return Auth::user()->currentTeam->livestreamAccount;
    }
}
