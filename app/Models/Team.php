<?php

namespace App\Models;

use App\Traits\Location\HasLocation;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Notifications\Notifiable;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\Team as JetstreamTeam;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;
use Modules\Social\Traits\Awardable;
use Modules\Social\Traits\Likable;
use Modules\Social\Traits\Postable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;
use Wimil\Followers\Traits\CanBeFollowed;

/**
 * Teams are just Teams
 */
class Team extends JetstreamTeam implements HasMedia
{
    use HasFactory, Notifiable,
        Likable, Postable, HasTags, CanBeFollowed, Awardable, HasProfilePhoto, HasSlug, HasLocation, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'handle',
        'start_date',
        'summary',
        'content',
    ];

    protected $dates = [
        'start_date'
    ];

    protected $appends = [
        'profile_photo_url',
        'location_short',
        'start_date_string'
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

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
                            ->generateSlugsFrom('name')
                            ->saveSlugsTo('handle');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'handle';
    }

    public function getThumbnailAttribute($value)
    {
        if (empty($value)) {
            return 'https://via.placeholder.com/200';
        }

        return $value;
    }

    public function attachMedia(array $mediaUrls): self
    {
        /** @var string $mediaUrl */
        foreach ($mediaUrls as $mediaUrl) {
            $this->addMediaFromUrl($mediaUrl)->toMediaCollection();
        }

        return $this;
    }

    // Relations //
    public function postsWithinTeam()
    {
        return $this->hasMany(Post::class);
    }

    public function teamApplications(): HasMany
    {
        return $this->hasMany(TeamApplication::class);
    }

    public function resources(): HasMany
    {
        return $this->hasMany(Post::class)->ofType(PostType::RESOURCE);
    }

    public function teamLink()
    {
        return route('social.teams.show', $this->id);
    }

    public function visits(): Relation
    {
        return visits($this)->relation();
    }

    public function bannerImage()
    {
        return optional($this->getMedia('team_banner_images')->first());
    }

    public function mainImage()
    {
        return optional($this->getMedia('team_main_images')->first());
    }

    public function profilePhoto()
    {
        return optional($this->getMedia('team_profile_photos')->first());
    }

    // Attributes //
    /**
     * Get the URL to the team's profile photo.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        return $this->profilePhoto()->getFullUrl() ?? $this->defaultProfilePhotoUrl();
    }

    public function sampleImages()
    {
        return $this->getMedia('team_sample_images');
    }

    public function getStartDateStringAttribute()
    {
        return $this->start_date?->toFormattedDateString();
    }

    public function getReviewScoreAttribute()
    {
        return null;
    }

    public function getReviewStatusAttribute()
    {
        return null;
    }

    public function owner()
    {
        return $this->hasOneThrough(User::class, Membership::class, 'team_id', 'id', 'id', 'user_id');
    }

    public function members()
    {
        return $this->users()->wherePivotNotIn('role', ['owner']);
    }

    public function allUsers() {
        return $this->users();
    }

    public function profile()
    {
        return route('social.teams.show', $this);
    }

    // Scopes //

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->where('name', 'LIKE', "%$search%");
    }

    public function scopeWithuser(Builder $query, User $user): Builder
    {
        return $query
            ->leftJoin('team_user', 'teams.id', '=', 'team_user.team_id')
            ->where('team_user.user_id', $user->id);
    }
}
