<?php

    namespace Modules\Advice\Providers;

    use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

    class EventServiceProvider extends ServiceProvider
    {
        /**
         * @var array
         */
        protected array $listen = [];
    }
