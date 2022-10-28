<?php

namespace App\Lenses;

use Illuminate\Database\Eloquent\Builder;

abstract class BaseLens
{
    public abstract function handle(Builder $query): Builder;
}
