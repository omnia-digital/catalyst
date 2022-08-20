<?php

    namespace Modules\Social\Models;

use App\Models\NullMedia;
use App\Models\User;
    use App\Support\Lexer\PrettyNumber;
    use Illuminate\Database\Eloquent\{Factories\HasFactory, Model, SoftDeletes};
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Storage;
    use Laravel\Jetstream\HasProfilePhoto;
    use Modules\Social\Database\Factories\ProfileFactory;
    use Spatie\MediaLibrary\HasMedia;
    use Spatie\MediaLibrary\InteractsWithMedia;
    use Spatie\Sluggable\HasSlug;
    use Spatie\Sluggable\SlugOptions;
    use Spatie\Tags\HasTags;

    class Profile extends Model implements HasMedia
    {
        use SoftDeletes, HasFactory, HasSlug, HasTags, HasProfilePhoto, InteractsWithMedia;

        public $incrementing = false;

        protected $dates = [
            'deleted_at',
            'last_fetched_at'
        ];

        protected $hidden = ['private_key'];

        protected $visible = [
            'id',
            'first_name',
            'last_name',
            'handle',
            'bio',
            'website',
            'user_id',
        ];

        protected $fillable = [
            'first_name',
            'last_name',
            'bio',
            'website',
            'user_id',
        ];

        protected $appends = [
            'name',
            'profile_photo_url'
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

        public function getNameAttribute(): string
        {
            return $this->first_name . " " . $this->last_name;
        }

        protected static function newFactory(): ProfileFactory
        {
            return ProfileFactory::new();
        }

        public function getSlugOptions(): SlugOptions
        {
            return SlugOptions::create()
                              ->generateSlugsFrom('name')
                              ->saveSlugsTo('handle');
        }

        /**
         * @return (mixed|string)[][]
         *
         * @psalm-return array{0: array{0: 'Phone', 1: '(123) 123-1234'}, 1: array{0: 'Email', 1: mixed}, 2: array{0: 'Title', 1: 'Senior Front-End Developer'}, 3: array{0: 'Team', 1: 'Product Development'}, 4: array{0: 'Location', 1: 'San Francisco'}, 5: array{0: 'Sits', 1: 'Oasis, 4th floor'}, 6: array{0: 'Salary', 1: '$145,000'}, 7: array{0: 'Birthday', 1: 'June 8, 1990'}}
         */
        public function fields(): array
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

        public function getDefaultScope(): string
        {
            return $this->is_private == true ? 'private' : 'public';
        }


        public function url(): string {
            return route('social.profile.show', $this->handle);
        }

        /**
         * @return (int|string)|NullMedia
         *
         * @psalm-return NullMedia|array-key
         */
        public function bannerImage()
        {
            return $this->getMedia('profile_banner_images')->first() ?? (new NullMedia('profile'));
        }

        /**
         * @return (int|string)|null
         *
         * @psalm-return array-key|null
         */
        public function photo()
        {
            return optional($this->getMedia('profile_photos')->first());
        }

        /**
         * Get the URL to the user's profile photo.
         *
         * @return string
         */
        public function getProfilePhotoUrlAttribute()
        {
            return $this->photo()->getFullUrl() ?? $this->defaultProfilePhotoUrl();
        }

        public function getCountryAttribute(): string
        {
            return 'USA';
        }

        public function getAwardsAttribute()
        {
            return $this->user->awards;
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

        /**
         * @psalm-return \Illuminate\Database\Eloquent\Relations\HasOne<Avatar>
         */
        public function avatar(): \Illuminate\Database\Eloquent\Relations\HasOne
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

        /**
         * @psalm-return \Illuminate\Support\Collection<empty, empty>
         */
        public function recommendFollowers(): \Illuminate\Support\Collection
        {
            return collect([]);
        }

        /**
         * @psalm-return \Illuminate\Database\Eloquent\Relations\BelongsToMany<self>
         */
        public function following(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
        {
            return $this->belongsToMany(self::class, 'followers', 'profile_id', 'following_id');
        }

        /**
         * @psalm-return \Illuminate\Database\Eloquent\Relations\BelongsToMany<self>
         */
        public function followers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
        {
            return $this->belongsToMany(self::class, 'followers', 'following_id', 'profile_id');
        }

        /**
         * @psalm-return \Illuminate\Database\Eloquent\Relations\HasMany<Like>
         */
        public function likes(): \Illuminate\Database\Eloquent\Relations\HasMany
        {
            return $this->hasMany(Like::class);
        }

        /**
         * @psalm-return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
         */
        public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
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
