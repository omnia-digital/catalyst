<?php

namespace Modules\Social\Observers;

use Modules\Social\Models\Profile;

class ProfileObserver
{
    public function created(Profile $profile): void
    {
        //
    }

    public function updated(Profile $profile): void
    {
        //
    }

    public function deleted(Profile $profile): void
    {
        //
    }

    public function restored(Profile $profile): void
    {
        //
    }

    public function forceDeleted(Profile $profile): void
    {
        //
    }
}
