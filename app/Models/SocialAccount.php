<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    protected $fillable = [
        'provider',
        'provider_user_id',
        'user_id',
        'avatar',
        'nickname',
        'email',
        'first_name',
        'last_name',
        'gender',
        'token',
        'team_token',
        'expires_in',
        'refresh_token',
        'verified',
    ];

    public static function findByProvider(string $provider, int|string $providerUserId)
    {
        return self::query()
            ->where('provider', $provider)
            ->where('provider_user_id', $providerUserId)
            ->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
