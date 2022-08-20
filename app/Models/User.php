<?php

    namespace App\Models;

use App\Traits\Team\HasTeams;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasTeams as JetstreamHasTeams;
use Laravel\Sanctum\HasApiTokens;
use Modules\Reviews\Models\Review;
use Modules\Social\Models\Like;
use Modules\Social\Models\Post;
use Modules\Social\Models\Profile;
use Modules\Social\Traits\Awardable;
use Modules\Social\Traits\HasBookmarks;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Wimil\Followers\Traits\Followable;

class User extends Authenticatable implements FilamentUser
    {
        use HasApiTokens,
            TwoFactorAuthenticatable,
            Notifiable,
            SoftDeletes,
            HasFactory,
            HasBookmarks,
            Followable,
            Awardable;
        use HasTeams, JetstreamHasTeams {
            HasTeams::hasTeamRole insteadof JetstreamHasTeams;
            HasTeams::isCurrentTeam insteadof JetstreamHasTeams;
            HasTeams::ownsTeam insteadof JetstreamHasTeams;
            HasTeams::ownedTeams insteadof JetstreamHasTeams;
            HasTeams::currentTeam insteadof JetstreamHasTeams;
        }

        public function canAccessFilament(): bool
        {
            if ($this->is_admin) {
                return true;
            }
            return str_ends_with($this->email, '@omniadigital.io') && $this->hasVerifiedEmail();
        }

        protected $dates = ['deleted_at', 'email_verified_at', '2fa_setup_at'];

        protected $fillable = [
            'first_name',
            'last_name',
            'email',
            'password',
        ];

        protected $hidden = [
            'email',
            'password',
            'is_admin',
            'remember_token',
            'email_verified_at',
            'two_factor_recovery_codes',
            'two_factor_secret',
            'deleted_at',
            'updated_at'
        ];

        protected $appends = [
            'profile_photo_url'
        ];

        //// Attributes ////

        public function getHandleAttribute() {
            return $this->profile?->handle;
        }

        public function getNameAttribute()
        {
            if ($this->profile()->exists()) {
                return $this->profile->name;
            }
        }

        public function getProfilePhotoUrlAttribute()
        {
            return $this->profile->profile_photo_url;
        }

        public function getOnlineStatusAttribute()
        {
            return true;
        }

        //// Relations ////

        public function profile() {
            if (!class_exists(Profile::class)) return;
            return $this->hasOne(Profile::class);
        }

        public function posts() {
            if (!class_exists(Post::class)) return;
            return $this->hasMany(Post::class);
        }

        public function reviews() {
            if (!class_exists(Review::class)) return;
            return $this->hasMany(Review::class);
        }

        public function likes() {
            if (!class_exists(Like::class)) return;
            return $this->hasMany(Like::class);
        }

        public function likedPosts() {
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

        //// Helper Methods ////

        public function url() {
            return route('social.profile.show', $this->handle);
        }

        public static function findByEmail($email)
        {
            return User::where('email', $email)->first();
        }
    }
