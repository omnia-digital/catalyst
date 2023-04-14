<?php

namespace Modules\Livestream\Services;

use Illuminate\Auth\AuthenticationException;
use Livestream\Livestream;
use Modules\Livestream\LivestreamAccount;

class LivestreamService extends Service
{
    /**
     * Get Livestream Account from CurrentTeam in Session or by Id
     * Return livestreamAccount if exists, throw exception if it doesn't or it fails
     *
     * @param  null|LivestreamAccount|int  $livestream_account_id
     * @return LivestreamAccount
     *
     * @throws AuthenticationException
     */
    public function getLivestreamAccount($livestream_account_id = null)
    {
        $livestreamAccount = null;
        if (! empty($livestream_account_id)) {
            if ($livestream_account_id instanceof LivestreamAccount) {
                $livestreamAccount = $livestream_account_id;
            } elseif (is_numeric($livestream_account_id)) {
                $livestreamAccount = LivestreamAccount::findOrFail((int) $livestream_account_id);
            }
        } else {
            if (auth()->user() && $currentTeam = auth()->user()->currentTeam()) {
                $livestreamAccount = $currentTeam->LivestreamAccount;
            } else {
                $livestreamAccount = null;
            }
        }

        return $livestreamAccount;
    }
}
