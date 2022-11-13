<?php

namespace App\Models;

use App\Traits\Location\HasLocation;
use App\Traits\Tag\HasTeamTags;
use App\Traits\Tag\HasTeamTypeTags;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Subscription;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\Team as JetstreamTeam;
use Modules\Forms\Models\Form;
use Modules\Forms\Models\FormType;
use Modules\Reviews\Traits\Reviewable;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;
use Modules\Social\Traits\Awardable;
use Modules\Social\Traits\HasHandle;
use Modules\Social\Traits\Likable;
use Modules\Social\Traits\Postable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;
use Wimil\Followers\Traits\CanBeFollowed;

/**
 * Teams are just Teams
 */
class Team extends JetstreamTeam implements HasMedia, Searchable
{
    use HasFactory,
        Notifiable,
        Likable,
        Postable,
        CanBeFollowed,
        Awardable,
        Reviewable,
        HasProfilePhoto,
        HasSlug,
        HasHandle,
        HasLocation,
        HasTeamTypeTags,
        InteractsWithMedia;

    use HasTeamTags, HasTags {
        HasTeamTags::tags insteadof HasTags;
    }

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
        'stripe_connect_id',
        'stripe_connect_onboarding_completed',
    ];

    protected $dates = [
        'start_date'
    ];

    protected $casts = [
        'stripe_connect_onboarding_completed' => 'boolean'
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

    public static function findByHandle($handle)
    {
        return Team::where('handle', $handle)->first();
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
        return $this->getMedia('team_sample_images')->count() ? $this->getMedia('team_sample_images') : (new NullMedia);
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

    public function forms(): HasMany
    {
        return $this->hasMany(Form::class);
    }

    public function applicationForm()
    {
        return $this->forms()
            ->where('form_type_id', FormType::teamApplicationFormId())
            ->whereNotNull('form_type_id')
            ->whereNotNull('published_at')
            ->first();
    }

    public function owner()
    {
        return $this->hasOneThrough(User::class, Membership::class, 'team_id', 'id', 'id', 'user_id')->where('role', 'owner');
    }

    public function members()
    {
        return $this->users()->wherePivotNotIn('role', ['owner']);
    }

    public function admins()
    {
        return $this->users()->wherePivotIn('role', ['admin']);
    }

    public function allUsers()
    {
        return $this->users();
    }

    public function applicationsCount()
    {
        return $this->teamApplications()->count();
    }

    public function hasUserWithEmail(string $email)
    {
        return $this->allUsers->contains(function ($user) use ($email) {
            return $user->email === $email;
        });
    }

    public function profile()
    {
        return route('social.teams.show', $this);
    }

    /** @note We are not using this currently. Save for future when we want teams to create custom plans */
    //public function teamPlans(): HasMany
    //{
    //    return $this->hasMany(TeamPlan::class);
    //}

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

    public function hasStripeConnectAccount(): bool
    {
        return !empty($this->stripe_connect_id);
    }

    public function stripeConnectOnboardingCompleted(): bool
    {
        return (bool)$this->stripe_connect_onboarding_completed;
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function subscribersCount(): int
    {
        return Subscription::where('team_id', $this->id)->count();
    }

    public function notify($value)
    {
        return $this->owner->notify($value);
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('teams.show', $this);

        return new SearchResult($this, $this->name, $url);
    }
}
