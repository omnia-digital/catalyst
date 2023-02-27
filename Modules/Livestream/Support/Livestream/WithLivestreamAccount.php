<?php namespace App\Support\Livestream;

use Illuminate\Support\Facades\Auth;

trait WithLivestreamAccount
{
    public function getLivestreamAccountProperty()
    {
        return Auth::user()->currentTeam->livestreamAccount;
    }
}
