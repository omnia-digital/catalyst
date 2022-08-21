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

        /**
         * @var string[]
         *
         * @psalm-var array{0: 'deleted_at', 1: 'email_verified_at', 2: '2fa_setup_at'}
         */
        protected $dates = ['deleted_at', 'email_verified_at', '2fa_setup_at'];

        /**
         * @var string[]
         *
         * @psalm-var array{0: 'first_name', 1: 'last_name', 2: 'email', 3: 'password'}
         */
        protected $fillable = [
            'first_name',
            'last_name',
            'email',
            'password',
        ];

        /**
         * @var string[]
         *
         * @psalm-var array{0: 'email', 1: 'password', 2: 'is_admin', 3: 'remember_token', 4: 'email_verified_at', 5: 'two_factor_recovery_codes', 6: 'two_factor_secret', 7: 'deleted_at', 8: 'updated_at'}
         */
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

        /**
         * @var string[]
         *
         * @psalm-var array{0: 'profile_photo_url'}
         */
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

        /**
         * @return true
         */
        public function getOnlineStatusAttribute(): bool
        {
            return true;
        }

        //// Relations ////

        /**
         * @return \Illuminate\Database\Eloquent\Relations\HasOne|null
         *
         * @psalm-return \Illuminate\Database\Eloquent\Relations\HasOne<Profile>|null
         */
        public function profile() {
            if (!class_exists(Profile::class)) return;
            return $this->hasOne(Profile::class);
        }

        /**
         * @return HasMany|null
         *
         * @psalm-return HasMany<Post>|null
         */
        public function posts() {
            if (!class_exists(Post::class)) return;
            return $this->hasMany(Post::class);
        }

        /**
         * @return HasMany|null
         *
         * @psalm-return HasMany<Review>|null
         */
        public function reviews() {
            if (!class_exists(Review::class)) return;
            return $this->hasMany(Review::class);
        }

        /**
         * @return HasMany|null
         *
         * @psalm-return HasMany<Like>|null
         */
        public function likes() {
            if (!class_exists(Like::class)) return;
            return $this->hasMany(Like::class);
        }

        public function likedPosts() {
            return $this->likes->map->post->flatten();
        }

        /**
         * @psalm-return \Illuminate\Database\Eloquent\Builder<TRelatedModel>
         */
        public function postMedia(): \Illuminate\Database\Eloquent\Builder
        {
            return $this->hasManyThrough(Media::class, Post::class, 'user_id', 'model_id')
                ->where('model_type', Post::class);
        }

        /**
         * @psalm-return HasMany<TeamInvitation>
         */
        public function teamInvitations(): HasMany
        {
            return $this->hasMany(TeamInvitation::class);
        }
        /**
         * @psalm-return HasMany<TeamApplication>
         */
        public function teamApplications(): HasMany
        {
            return $this->hasMany(TeamApplication::class);
        }

        //// Helper Methods ////

        public function url(): string {
            return route('social.profile.show', $this->handle);
        }

        public static function findByEmail(string $email): static|null
        {
            return User::where('email', $email)->first();
        }
    }
