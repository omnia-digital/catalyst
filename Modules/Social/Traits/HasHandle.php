<?php

namespace Modules\Social\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasHandle
{
    public abstract static function findByHandle($handle);
}
