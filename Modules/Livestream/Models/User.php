<?php

namespace Modules\Livestream\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Lab404\Impersonate\Services\ImpersonateManager;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Modules\Livestream\Actions\Fortify\CreateNewUser;
use Modules\Livestream\Omnia;

/**
 * @property Team $currentTeam
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'email',
        'password',
        'profile_photo_path',
        'timezone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'trial_ends_at' => 'datetime',
    ];

    /**
     * Create user from user's data of Facebook.
     */
    public static function createUserFromFacebook(SocialiteUser $user): User
    {
        $socialAccount = SocialAccount::findByProvider('facebook', $user->getId());

        // If we found a social account then just return the attached user.
        if ($socialAccount) {
            return $socialAccount->user;
        }

        // Otherwise, create user + user account.
        [$firstName, $lastName] = Omnia::extractFullName($user->getName());

        $dbUser = (new CreateNewUser)->create([
            'email' => $user->getEmail(),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'avatar' => $user->getAvatar(),
        ], true);

        $dbUser->createSocialAccount($user);

        return $dbUser;
    }

    public function createSocialAccount(SocialiteUser $user): SocialAccount
    {
        [$firstName, $lastName] = Omnia::extractFullName($user->getName());

        return $this->socialAccount()->create([
            'provider_user_id' => $user->getId(),
            'provider' => 'facebook',
            'avatar' => $user->getAvatar(),
            'nickname' => $user->getNickname(),
            'email' => $this->email,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'gender' => null,
            'token' => $user->token,
            'expires_in' => $user->expiresIn,
            'refresh_token' => $user->refreshToken,
        ]);
    }

    public function socialAccount(): HasOne
    {
        return $this->hasOne(SocialAccount::class);
    }

    public function scopeAdmin(Builder $query)
    {
        return $query->whereIn('email', Omnia::adminEmails());
    }

    public function canImpersonate(): bool
    {
        return $this->isAdmin();
    }

    public function isAdmin(): bool
    {
        return in_array($this->email, Omnia::adminEmails());
    }

    public function isImpersonating(): bool
    {
        $impersonate_manager = app()->make(ImpersonateManager::class);

        if ($impersonate_manager->isImpersonating()) {
            return true;
        } else {
            return false;
        }
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function livestreamAccounts(): HasManyThrough
    {
        return $this->hasManyThrough(LivestreamAccount::class, Team::class);
    }

    public function getNameAttribute()
    {
        return $this->person?->name;
    }

    public function getFirstNameAttribute()
    {
        return $this->person?->first_name;
    }

    public function getLastNameAttribute()
    {
        return $this->person?->last_name;
    }

    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        if (Str::startsWith($this->profile_photo_path, ['http', 'https'])) {
            return $this->profile_photo_path;
        }

        return $this->profile_photo_path
            ? Storage::disk($this->profilePhotoDisk())->url($this->profile_photo_path)
            : $this->defaultProfilePhotoUrl();
    }

    /**
     * Route notifications for the Slack channel.
     *
     * @param  Notification  $notification
     * @return string
     */
    public function routeNotificationForSlack($notification)
    {
        return $this->slack_webhook_url;
    }
}
