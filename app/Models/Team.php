<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;
use Modules\Social\Models\Post;
use Modules\Social\Traits\Likable;
use Modules\Social\Traits\Postable;
use Spatie\Tags\HasTags;

/**
 * Projects are just Teams
 */
class Team extends JetstreamTeam
{
    use HasFactory, Likable, Postable, HasTags;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'personal_team' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'start_date',
        'personal_team',
        'summary',
        'target_audience',
        'content',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    public function getThumbnailAttribute($value)
    {
        if (empty($value)) {
            return 'https://via.placeholder.com/200';
        }

        return $value;
    }

    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class);
    }

    public function projectLink() {
        return route('projects.show', $this->id);
    }

    public function teamLocation(): HasOne
    {
        return $this->hasOne(TeamLocation::class);
    }

    public function getLocationAttribute()
    {
        if($this->teamLocation) {
            return $this->teamLocation->city . " " . $this->teamLocation->state . " " . $this->teamLocation->country;
        }

        return null;
    }

    public function getReviewScoreAttribute()
    {
        return null;
    }

    public function getReviewStatusAttribute()
    {
        return null;
    }

    public function members()
    {
        return $this->allUsers();
    }

    public function profile()
    {
        return route('social.projects.show', $this->id);
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->where('name', 'LIKE', "%$search%");
    }
}
