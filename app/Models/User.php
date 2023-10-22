<?php

namespace App\Models;

use OmniaDigital\CatalystCore\Traits\CatalystTraits;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    use CatalystTraits;

    protected $casts = [
        'deleted_at' => 'datetime',
        'email_verified_at' => 'datetime',
        '2fa_setup_at' => 'datetime',
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
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

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
    ];
}

