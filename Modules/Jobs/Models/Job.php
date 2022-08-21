<?php

namespace Modules\Jobs\Models;

use App\Models\User;
use App\Traits\Coupon\HasCoupon;
use App\Traits\Transaction\HasTransaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Jetstream;
use Modules\Jobs\Enums\JobAddons;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;

class Job extends Model
{
    use HasFactory, HasTransaction, HasCoupon, HasSlug, HasTags;

    /**
     * @var string[]
     *
     * @psalm-var array{0: 'title', 1: 'slug', 2: 'description', 3: 'team_id', 4: 'user_id', 5: 'apply_type', 6: 'apply_value', 7: 'payment_type', 8: 'budget', 9: 'location', 10: 'hours_per_week_id', 11: 'is_remote', 12: 'project_size_id', 13: 'is_active'}
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'team_id',
        'user_id',
        'apply_type',
        'apply_value',
        'payment_type',
        'budget',
        'location',
        'hours_per_week_id',
        'is_remote',
        'project_size_id',
        'is_active'
    ];

    /**
     * @var string[]
     *
     * @psalm-var array{is_remote: 'boolean', is_active: 'boolean'}
     */
    protected $casts = [
        'is_remote' => 'boolean',
        'is_active' => 'boolean'
    ];

    protected string $table = 'job_positions';

    protected static function booted()
    {
        static::creating(function (self $job) {
            $job->user_id = Auth::id();
        });

        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('is_active', 1);
        });
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
                          ->generateSlugsFrom('title')
                          ->saveSlugsTo('slug');
    }
}
