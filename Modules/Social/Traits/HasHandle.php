<?php

namespace Modules\Social\Traits;

trait HasHandle
{
    abstract public static function findByHandle($handle);
}
