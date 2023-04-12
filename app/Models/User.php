<?php

namespace App\Models;

use App\Traits\Team\HasTeams;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasTeams as JetstreamHasTeams;
use Laravel\Passport\HasApiTokens;
use Modules\Billing\Models\Builders\CashierSubscriptionBuilder;
use Modules\Billing\Traits\WithChargentSubscriptions;
use Modules\Forms\Models\FormSubmission;
use Modules\Jobs\Support\HasJobs;
use Modules\Jobs\Support\HasTransactions;
use Modules\Reviews\Models\Review;
use Modules\Social\Models\Like;
use Modules\Social\Models\Post;
use Modules\Social\Models\Profile;
use Modules\Social\Traits\Awardable;
use Modules\Social\Traits\HasBookmarks;
use Modules\Social\Traits\HasHandle;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Traits\HasRoles;
use Thomasjohnkane\Snooze\Traits\SnoozeNotifiable;
use Wimil\Followers\Traits\Followable;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    use HasApiTokens,
        TwoFactorAuthenticatable,
        Notifiable,
        SoftDeletes,
        HasFactory,
        HasBookmarks,
        Followable,
        Awardable,
        HasHandle,
        HasRoles,
        HasJobs,
        HasTransactions,
        SnoozeNotifiable;
    use HasTeams, JetstreamHasTeams {
        HasTeams::teams insteadof JetstreamHasTeams;
        HasTeams::hasTeamRole insteadof JetstreamHasTeams;
        HasTeams::isCurrentTeam insteadof JetstreamHasTeams;
        HasTeams::ownsTeam insteadof JetstreamHasTeams;
        HasTeams::ownedTeams insteadof JetstreamHasTeams;
        HasTeams::currentTeam insteadof JetstreamHasTeams;
        HasTeams::teamRole insteadof JetstreamHasTeams;
    }

    use Billable, WithChargentSubscriptions;

    protected $dates = ['deleted_at', 'email_verified_at', '2fa_setup_at'];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    protected $hidden = [
        //            'email',
        'password',
        //            'is_admin',
        'remember_token',
        //            'email_verified_at',
        'two_factor_recovery_codes',
        'two_factor_secret',
        '2fa_secret',
        '2fa_backup_codes',
        '2fa_setup_at',
        'stripe_id',
        'pm_type',
        'pm_last_four',
        //            'deleted_at',
        //            'updated_at'
    ];

    protected $appends = [
    ];

    public static function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public static function findByHandle($handle)
    {
        return User::with('profile')
            ->whereHas('profile', function ($q) use ($handle) {
                $q->where('handle', $handle);
            })->first();
    }

    public function canAccessFilament(): bool
    {
        return true;
        if ($this->is_admin) {
            return true;
        }

        return str_ends_with($this->email, '@omniadigital.io') && $this->hasVerifiedEmail();
    }

    public function getIsAdminAttribute()
    {
        return $this->hasRole('super-admin');
    }

        //// Attributes ////

    public function getHandleAttribute()
    {
        $this->load('profile');

        return $this->profile?->handle;
    }

    public function getNameAttribute()
    {
        $this->load('profile');
        return $this->profile?->name;
    }

    public function getFirstNameAttribute()
    {
        $this->load('profile');
        return $this->profile?->first_name;
    }

    public function getLastNameAttribute()
    {
        $this->load('profile');
        return $this->profile?->last_name;
    }

    public function getContactIdAttribute()
    {
        $this->load('profile');
        return $this->profile?->salesforce_contact_id;
    }

    public function getProfilePhotoUrlAttribute()
    {
        $this->load('profile');
        return $this->profile->profile_photo_url;
    }

    public function getOnlineStatusAttribute()
    {
        return true;
    }

    public function deleteProfilePhoto()
    {
        $this->profile->deleteProfilePhoto();
    }

    //// Relations ////

    public function roles(): BelongsToMany
    {
        return $this->morphToMany(
            config('permission.models.role'),
            'model',
            config('permission.table_names.model_has_roles'),
            config('permission.column_names.model_morph_key'),
            PermissionRegistrar::$pivotRole
        );
    }

    public function profile()
    {
        if (! class_exists(Profile::class)) {
            return;
        }

        return $this->hasOne(Profile::class);
    }

    public function posts()
    {
        if (! class_exists(Post::class)) {
            return;
        }

        return $this->hasMany(Post::class);
    }

    public function reviews()
    {
        if (! class_exists(Review::class)) {
            return;
        }

        return $this->hasMany(Review::class);
    }

    public function likes()
    {
        if (! class_exists(Like::class)) {
            return;
        }

        return $this->hasMany(Like::class);
    }

    public function likedPosts()
    {
        return $this->likes->map->post->flatten();
    }

    public function postMedia()
    {
        return $this->hasManyThrough(Media::class, Post::class, 'user_id', 'model_id')
            ->where('model_type', Post::class);
    }

    public function teamInvitations(): HasMany
    {
        return $this->hasMany(TeamInvitation::class);
    }

    public function teamApplications(): HasMany
    {
        return $this->hasMany(TeamApplication::class);
    }

    public function formSubmissions(): HasMany
    {
        return $this->hasMany(FormSubmission::class);
    }

    //// Helper Methods ////

    public function url()
    {
        return route('social.profile.show', $this->handle);
    }

    /**
     * Begin creating a new subscription.
     *
     * @param  string  $name
     * @param  string|string[]  $prices
     * @return \Laravel\Cashier\SubscriptionBuilder
     */
    public function newSubscription($name, $prices = [])
    {
        return new CashierSubscriptionBuilder($this, $name, $prices);
    }

    /** @note We are not using this currently. Save for future when we want teams to create custom plans */
    //public function stripeConnectCustomers(): HasMany
    //{
    //    return $this->hasMany(StripeConnectCustomer::class);
    //}

    /** @note We are not using this currently. Save for future when we want teams to create custom plans */
    //public function isStripeConnectCustomerOf(Team $team): bool
    //{
    //    return $this->stripeConnectCustomers->where('team_id', $team->id)->isNotEmpty();
    //}

    /** @note We are not using this currently. Save for future when we want teams to create custom plans */
    //public function stripeConnectCustomerOf(Team $team): ?StripeConnectCustomer
    //{
    //    return $this->stripeConnectCustomers()
    //        ->where('team_id', $team->id)
    //        ->first();
    //}
}
