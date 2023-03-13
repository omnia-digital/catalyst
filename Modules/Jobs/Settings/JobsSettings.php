<?php

namespace Modules\Jobs\Settings;

use Spatie\LaravelSettings\Settings;

class JobsSettings extends Settings
{
    public ?string $featured_days;
    public ?string $featured_jobs_limit;
    public ?string $posting_price;

    public static function group(): string
    {
        return 'jobs';
    }
}
