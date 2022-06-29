<?php

    namespace App\Models;

use App\Traits\HasTeams;
use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Fortify\TwoFactorAuthenticatable;
    use Laravel\Jetstream\HasProfilePhoto;
    use Laravel\Jetstream\HasTeams as JetstreamHasTeams;
    use Laravel\Sanctum\HasApiTokens;
    use Modules\Social\Models\Like;
    use Modules\Social\Models\Post;
    use Modules\Social\Models\Profile;
    use Modules\Social\Traits\Awardable;
    use Modules\Social\Traits\HasBookmarks;
    use Spatie\MediaLibrary\MediaCollections\Models\Media;
    use Wimil\Followers\Traits\Followable;

    class User extends Authenticatable
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
            HasTeams::ownedTeams insteadof JetstreamHasTeams;
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

        public function setProfilePhotoUrlAttribute($value)
        {
            return $this->profile->profile_photo_url = $value;
        }

        public function getProfilePhotoUrlAttribute()
        {
            return $this->profile()->select(['profile_photo_path'])->first()->profile_photo_url;
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

        public function allTeams()
        {
            return $this->joinedTeams()->orWhere('user_id', $this->id);
        }

        public function joinedTeams()
        {
            return Team::whereHas('users', function($query) {
                $query->where('team_user.user_id', $this->id);
            });
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
