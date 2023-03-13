<?php

namespace Modules\Jobs\Models;

use App\Traits\Coupon\HasCoupon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Jobs\Models\User;
use Modules\Jobs\Support\Transaction\HasTransaction;
use Illuminate\Database\Eloquent\Builder;
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
        'experience_level_id',
        'job_length_id',
        'project_size_id',
        'is_active'
    ];

    protected $casts = [
        'is_remote' => 'boolean',
        'is_active' => 'boolean'
    ];

    protected $table = 'job_positions';

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Jetstream::$teamModel, 'team_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addons()
    {
        return $this->belongsToMany(JobAddon::class);
    }

    /**
     * Get featured jobs
     *
     * @param $query
     * @param null $inDays
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function scopeFeatured($query, $inDays = null)
    {
        return $query->whereHas('addons', fn($query) => $query->where('code', JobAddons::FEATURED_JOB))
            ->when($inDays, fn($query) => $query->whereDate('created_at', '>=', now()->subDays($inDays)));
    }

    /**
     * @param string $code
     * @return bool
     */
    public function hasAddon(string $code)
    {
        return $this->addons->contains('code', $code);
    }

    /**
     * Get apply link base on apply type (email or link).
     *
     * @return string
     */
    public function getApplyLinkAttribute()
    {
        return $this->apply_type === 'email'
            ? 'mailto::' . $this->apply_value . '?subject=Apply for ' . $this->title
            : $this->apply_value;
    }
}
