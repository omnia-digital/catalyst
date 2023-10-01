<?php

namespace Modules\Social\Observers;

use Modules\Social\Models\Profile;

class ProfileObserver
{
    public function created(Profile $profile)
    {
        //
    }

    public function updating(Profile $profile)
    {
        $profile->isDirty('score') && $profile->score_updated_at = now();
    }

    public function updated(Profile $profile)
    {
        //
    }

    public function deleted(Profile $profile)
    {
        //
    }

    public function restored(Profile $profile)
    {
        //
    }

    public function forceDeleted(Profile $profile)
    {
        //
    }
}
