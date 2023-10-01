<?php

namespace App\Lenses;

use Illuminate\Database\Eloquent\Builder;
use RuntimeException;

trait WithLenses
{
    protected function applyLens(Builder $query): Builder
    {
        if (! property_exists($this, 'lens')) {
            return $query;
        }

        if (! app()->bound("lenses.{$this->lens}")) {
            return $query;
        }

        $lensClass = app("lenses.{$this->lens}");

        if (! $lensClass instanceof BaseLens) {
            throw new RuntimeException("{$lensClass} must extends BaseLens class");
        }

        $lensClass->handle($query);

        return $query;
    }
}
