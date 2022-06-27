<?php

    namespace Modules\Social\Models;

    use App\Models\User;
    use App\Util\Lexer\PrettyNumber;
    use Illuminate\Database\Eloquent\{Factories\HasFactory, Model, SoftDeletes};
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Storage;
    use Modules\Social\Database\Factories\ProfileFactory;
    use Spatie\Sluggable\HasSlug;
    use Spatie\Sluggable\SlugOptions;

    class Profile extends Model
    {
        use SoftDeletes, HasFactory, HasSlug;

        public $incrementing = false;

        protected $dates = [
            'deleted_at',
            'last_fetched_at'
        ];

        protected $hidden = ['private_key'];

        protected $visible = [
            'id',
            'name',
            'handle',
            'user_id',
        ];

        protected $fillable = [
            'name',
            'user_id',
        ];

        /**
         * Get the route key for the model.
         *
         * @return string
         */
        public function getRouteKeyName()
        {
            return 'handle';
        }

        protected static function newFactory()
        {
            return ProfileFactory::new();
        }

        public function getSlugOptions(): SlugOptions
        {
            return SlugOptions::create()
                              ->generateSlugsFrom('name')
                              ->saveSlugsTo('handle');
        }

        public function fields()
        {
            return [
                ['Phone', '(123) 123-1234'], // $this->phone
                ['Email', $this->user->email],
                ['Title', 'Senior Front-End Developer'],
                ['Team', 'Product Development'],
                ['Location', 'San Francisco'],
                ['Sits', 'Oasis, 4th floor'],
                ['Salary', '$145,000'],
                ['Birthday', 'June 8, 1990'],
            ];
        }

        public function getDefaultScope()
        {
            return $this->is_private == true ? 'private' : 'public';
        }

        public function url() {
            return route('social.profile.show', $this->handle);
        }

        public function getCountryAttribute()
        {
            return 'USA';
        }

        public function followingCount($short = false)
        {
            $count = Cache::remember('profile:following_count:' . $this->id, now()->addMonths(1), function () {
                if ($this->user->settings->show_profile_following_count == false) {
                    return 0;
                }
                $count = DB::table('followers')->where('profile_id', $this->id)->count();
                if ($this->following_count != $count) {
                    $this->following_count = $count;
                    $this->save();
                }

                return $count;
            });

            return $short ? PrettyNumber::convert($count) : $count;
        }

        public function followerCount($short = false)
        {
            $count = Cache::remember('profile:follower_count:' . $this->id, now()->addMonths(1), function () {
                if ($this->user->settings->show_profile_follower_count == false) {
                    return 0;
                }
                $count = DB::table('followers')->where('following_id', $this->id)->count();
                if ($this->followers_count != $count) {
                    $this->followers_count = $count;
                    $this->save();
                }

                return $count;
            });

            return $short ? PrettyNumber::convert($count) : $count;
        }

        public function follows($profile): bool
        {
            return Follow::whereProfileId($this->id)->whereFollowingId($profile->id)->exists();
        }

        public function followedBy($profile): bool
        {
            return Follow::whereProfileId($profile->id)->whereFollowingId($this->id)->exists();
        }

        public function avatar()
        {
            return $this->hasOne(Avatar::class)->withDefault([
                'media_path'   => 'public/avatars/default.jpg',
                'change_count' => 0
            ]);
        }

        public function avatarUrl()
        {
            $url = Cache::remember('avatar:' . $this->id, now()->addYears(1), function () {
                $avatar = $this->avatar;

                if ($avatar->cdn_url) {
                    return $avatar->cdn_url ?? url('/storage/avatars/default.jpg');
                }

                if ($avatar->is_remote) {
                    return $avatar->cdn_url ?? url('/storage/avatars/default.jpg');
                }

                $path = $avatar->media_path;
                $path = "{$path}?v={$avatar->change_count}";

                return config('app.url') . Storage::url($path);
            });

            return $url;
        }

        public function recommendFollowers()
        {
            return collect([]);
        }

        public function following()
        {
            return $this->belongsToMany(self::class, 'followers', 'profile_id', 'following_id');
        }

        public function followers()
        {
            return $this->belongsToMany(self::class, 'followers', 'following_id', 'profile_id');
        }

        public function likes()
        {
            return $this->hasMany(Like::class);
        }

        public function user()
        {
            return $this->belongsTo(User::class);
        }

        /**
         * Advice
         */

        /**
         * Credibility Rating for Advice
         *
         * @return void
         */
        public function getCredibilityRatingAttribute()
        {

        }
    }
