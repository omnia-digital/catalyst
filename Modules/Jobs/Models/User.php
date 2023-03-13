<?php

namespace Modules\Jobs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * @param int $size
     * @return string
     */
    public function gravatar(int $size = 512)
    {
        return 'https://secure.gravatar.com/avatar/' . md5(Str::lower($this->email)) . '?size=' . $size;
    }

    /**
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->getKey() === 1;
    }

    /**
     * Who can impersonate an user.
     *
     * @return bool
     */
    public function canImpersonate()
    {
        return $this->isSuperAdmin();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Route notifications for the Slack channel.
     *
     * @param  \Illuminate\Notifications\Notification $notification
     * @return string
     */
    public function routeNotificationForSlack($notification)
    {
        return $this->slack_incoming_webhook;
    }
}
