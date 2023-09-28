<?php

namespace App\Models;

use App\Traits\Location\HasLocation;
use App\Traits\Tag\HasTeamTags;
use App\Traits\Tag\HasTeamTypeTags;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
use Modules\Jobs\Models\JobPosition;
use Modules\Jobs\Support\HasJobs;
use Modules\Reviews\Traits\Reviewable;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;
use Modules\Social\Models\TeamNotification;
use Modules\Social\Traits\Awardable;
use Modules\Social\Traits\HasAssociations;
use Modules\Social\Traits\HasHandle;
use Modules\Social\Traits\Likable;
use Modules\Social\Traits\Postable;
use Overtrue\LaravelFollow\Traits\Followable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Models\Role;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;
use Trans;

/**
 * Teams are just Teams
 */
class Team extends JetstreamTeam implements HasMedia, Searchable
{
    use HasFactory, Notifiable, Likable, Postable, Followable, Awardable, Reviewable, HasProfilePhoto, HasSlug, HasHandle, HasLocation, HasTeamTypeTags, InteractsWithMedia, HasAssociations, HasJobs;

    use HasTeamTags, HasTags {
        HasTeamTags::tags insteadof HasTags;
    }

    const DEFAULT_TEAM_NAME = 'Default Org';

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

    protected $casts = [
        'stripe_connect_onboarding_completed' => 'boolean',
        'start_date' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
        'location_short',
        'start_date_string',
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

    public static function findByHandle($handle)
    {
        return Team::where('handle', $handle)
            ->first();
    }

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
            $this->addMediaFromUrl($mediaUrl)
                ->toMediaCollection();
        }

        return $this;
    }

    public function getDefaultRoleAttribute($value)
    {
        return config('platform.teams.default_member_role');
    }

    public function hasInfoIsFilled(): bool
    {
        return ! $this->hasDefaultTeamName() && ! empty($this->phone) && ! empty($this->city) && ! empty($this->state);
    }

    public function hasDefaultTeamName(): bool
    {
        return $this->name === $this->getDefaultTeamName();
    }

    public function getDefaultTeamName(): string
    {
        return $this->owner?->profile?->first_name . Trans::get("'s Team") ?? Trans::get('Default Team');
    }

    // Relations //
    public function teamNotifications(): HasMany
    {
        return $this->hasMany(TeamNotification::class);
    }

    public function postsWithinTeam()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get all of the pending user applications for the team.
     */
    public function teamApplications(): HasMany
    {
        return $this->hasMany(TeamApplication::class);
    }

    public function resources(): HasMany
    {
        return $this->hasMany(Post::class)
            ->ofType(PostType::ARTICLE)
            ->ofType(PostType::RESOURCE);
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
        return optional($this->getMedia('team_banner_images')
            ->first());
    }

    public function mainImage()
    {
        return optional($this->getMedia('team_main_images')
            ->first());
    }

    public function profilePhoto()
    {
        return optional($this->getMedia('team_profile_photos')
            ->first());
    }

    // Attributes //

    /**
     * Get the URL to the team's profile photo.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        return $this->profilePhoto()
            ->getFullUrl() ?? $this->defaultProfilePhotoUrl();
    }

    public function sampleImages()
    {
        return $this->getMedia('team_sample_images')
            ->count() ? $this->getMedia('team_sample_images') : (new NullMedia);
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

    //** Memberships and Roles  **//

//    public function owner()
//    {
//        return $this->morphOne(Membership::class, 'model')
//                    ->where('role_id', $this->getRoleByName(config('platform.teams.default_owner_role'))
//                                           ->id);
//    }

    public function owners()
    {
        return $this->users()
            ->whereHas('roles', function ($query) {
                $query->where('name', config('platform.teams.default_owner_role'))
                    ->where('roles.team_id', $this->id);
            })->limit(1);
    }

    public function getOwnerAttribute()
    {
        return $this->owners()
            ->first();
    }

    public function users()
    {
        return $this->morphedByMany(User::class, 'model', 'model_has_roles')
            ->withPivot('role_id')
            ->withTimestamps()
            ->as('membership');
    }

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    public function members(): BelongsToMany
    {
        $roleId = $this->getRoleByName(config('platform.teams.default_owner_role'))?->id;

        return $this->users()
            ->wherePivotNotIn('role_id', [$roleId]);
    }

    public function admins()
    {
        $roleId = $this->getRoleByName(config('platform.teams.default_admin_role'))->id;

        return $this->users()
            ->wherePivotIn('role_id', [$roleId]);
    }

    public function getRoleByName($roleName)
    {
        return $this->roles()
            ->where('name', $roleName)
            ->first();
    }

    public function allUsers()
    {
        return $this->users();
    }

    public function applicationsCount()
    {
        return $this->teamApplications()
            ->count();
    }

    public function hasUserWithEmail(string $email)
    {
        return $this->allUsers->contains(function ($user) use ($email) {
            return $user->email === $email;
        });
    }

    public function profile(): string
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
        return $query->where('name', 'LIKE', "%{$search}%");
    }

    public function scopeWithUser(Builder $query, User $user): Builder
    {
        return $query->whereHas('users', function ($query) use ($user) {
            $query->where('model_has_roles.model_id', $user->id)
                ->where('model_has_roles.model_type', User::class);
        });
    }

    public function hasStripeConnectAccount(): bool
    {
        return ! empty($this->stripe_connect_id);
    }

    public function stripeConnectOnboardingCompleted(): bool
    {
        return (bool) $this->stripe_connect_onboarding_completed;
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function subscribersCount(): int
    {
        return Subscription::where('team_id', $this->id)
            ->count();
    }

    public function notify($value)
    {
        return $this->owner->notify($value);
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('social.teams.show', $this);

        return (new SearchResult($this, $this->name, $url))->setType(Trans::get('Teams'));
    }

    /**
     * Jobs
     */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobs()
    {
        return $this->hasMany(JobPosition::class);
    }

    /**
     * Check if the company is default or not.
     *
     * @return mixed
     */
    public function isDefaultCompany()
    {
        return $this->personal_team;
    }
}
