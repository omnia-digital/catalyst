<?php

namespace App\Lenses;

use Illuminate\Database\Eloquent\Builder;

abstract class BaseLens
{
    abstract public function handle(Builder $query): Builder;
}
