<?php

namespace Modules\Jobs\Support;

use Modules\Jobs\Models\JobPosition;

trait HasJobs
{
    public function jobs()
    {
        return $this->hasMany(JobPosition::class);
    }
}
