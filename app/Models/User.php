<?php

    namespace App\Models;

    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Fortify\TwoFactorAuthenticatable;
    use Laravel\Jetstream\HasProfilePhoto;
    use Laravel\Jetstream\HasTeams;
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
            HasProfilePhoto,
            TwoFactorAuthenticatable,
            Notifiable,
            SoftDeletes,
            HasFactory,
            HasTeams,
            HasBookmarks,
            Followable,
            Awardable;

        /**
         * The attributes that should be mutated to dates.
         *
         * @var array
         */
        protected $dates = ['deleted_at', 'email_verified_at', '2fa_setup_at'];

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'first_name',
            'last_name',
            'email',
            'password',
        ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
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

        protected $appends = [
            'profile_photo_url'
        ];

        public static function findByEmail($email)
        {
            return User::where('email', $email)->first();
        }

        public function getNameAttribute() {
            if ($this->profile()->exists()) {
                return $this->profile->name;
            }
            return $this->first_name . " " . $this->last_name;
        }

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

        public function url() {
            return route('social.profile.show', $this->handle);
        }

        public function getHandleAttribute() {
            return $this->profile?->handle;
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

        /**
         * Get all of the pending invitations for the user.
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function teamInvitations(): HasMany
        {
            return $this->hasMany(TeamInvitation::class);
        }

        /**
         * Get all of the pending applications for the user.
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function teamApplications(): HasMany
        {
            return $this->hasMany(TeamApplication::class);
        }

        public function receivesBroadcastNotificationsOn() {
            return 'App.User.' . $this->id;
        }
    }
