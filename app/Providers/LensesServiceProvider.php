<?php

namespace App\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class LensesServiceProvider extends ServiceProvider implements DeferrableProvider
{
    protected array $lensClasses = [];

    public function registerLens(string $name, string $class): static
    {
        $this->lensClasses[] = $class;

        $this->app->singleton("lenses.$name", function () use ($class) {
            return new $class;
        });

        return $this;
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array_unique($this->lensClasses);
    }
}
