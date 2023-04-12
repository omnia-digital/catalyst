<?php

namespace Modules\Social\Models;

use App\Models\NullMedia;
use App\Models\User;
use App\Support\Lexer\PrettyNumber;
use App\Traits\Tag\HasProfileTags;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\HasProfilePhoto;
use Modules\Social\Database\Factories\ProfileFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;
use Squire\Models\Country;

class Profile extends Model implements HasMedia, Searchable
{
    use SoftDeletes, HasFactory, HasSlug, HasProfilePhoto, InteractsWithMedia;
    use HasProfileTags, HasTags {
        HasProfileTags::tags insteadof HasTags;
    }

    public $incrementing = false;

    protected $dates = [
        'deleted_at',
        'last_fetched_at',
    ];

    protected $casts = [
        'birth_date' => 'datetime:Y-m-d',
    ];

    protected $hidden = ['private_key'];

    protected $visible = [
        'id',
        'first_name',
        'last_name',
        'handle',
        'bio',
        'country',
        'website',
        'birth_date',
        'user_id',
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'bio',
        'country',
        'website',
        'birth_date',
        'user_id',
        'salesforce_contact_id',
    ];

    protected $appends = [
        'name',
        'profile_photo_url',
    ];

    public static function getTrending()
    {
        return Profile::query()->orderByDesc('followers_count');

        $trending = Profile::withCount('followers')
                            ->with('user')
                            ->orderBy('followers_count', 'desc')
                            ->orderBy('created_at', 'desc');

        return $trending;
    }

    public static function getTableColumns(): array
    {
        return [
            ImageColumn::make('profile_photo_url')
                       ->label('Photo'),
            TextColumn::make('first_name')->sortable()->searchable(),
            TextColumn::make('last_name')->sortable()->searchable(),
            IconColumn::make('user.is_admin')
                      ->label('Admin')
                      ->boolean()->sortable(),
            TextColumn::make('user.id')->label('User ID')->sortable()->searchable(),
            TextColumn::make('user.email')
                      ->label('Email')->sortable()->searchable(),
            TextColumn::make('user.stripe_id')
                      ->label('Stripe')
                      ->sortable()
                      ->searchable()
                      ->url(function (Profile $record): string {
                          return "https://dashboard.stripe.com/customers/{$record->user?->stripe_id}";
                      }, true),
            TextColumn::make('created_at')
                      ->dateTime()->sortable()->searchable(),
            TextColumn::make('updated_at')
                      ->dateTime()->sortable()->searchable(),
        ];
    }

    protected static function newFactory()
    {
        return ProfileFactory::new();
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'handle';
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
                          ->generateSlugsFrom('name')
                          ->saveSlugsTo('handle')
                          ->doNotGenerateSlugsOnUpdate();
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

    public function urlLink()
    {
        return route('social.profile.show', $this->handle);
    }

    public function bannerImage()
    {
        return $this->getMedia('profile_banner_images')->first() ?? (new NullMedia('profile'));
    }

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

    public function countryFlag()
    {
        return Country::select('flag')->where('code_3', $this->country)->pluck('flag')->first();
    }

    public function displayCountry()
    {
        return $this->countryFlag() . ' ' . strtoupper($this->country);
    }

    public function getAwardsAttribute()
    {
        return $this->user->awards;
    }

    public function updateFollowingCount($short = false)
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

    public function updateFollowerCount($short = false)
    {
        $count = Cache::remember('profile:follower_count:' . $this->id, now()->addMinutes(60), function () {
            if ($this->user->settings->show_profile_follower_count == false) {
                return 0;
            }
//                $count = $this->withCount('followers')->orderBy('followers_count','desc')->get();
            $count = DB::table('followers')->where('following_id', $this->id)->count();
            if ($this->followers_count != $count) {
                $this->followers_count = $count;
                $this->save();
            }

            return $count;
        });

        return $short ? PrettyNumber::convert($count) : $count;
    }

    /**
     * Get the Profiles with the most likes on posts
     *
     * @return void
     */
    public function getMostPostLikes()
    {
        if (! empty($this->user)) {
            $type = 'post';

            return Post::where('user_id', $this->user->id)
                ->withCount('post.likes')
                ->when($type, fn ($query) => $query->where('type', $this->type))
                ->orderBy('likes_count', 'desc');
        }
    }

    public function isFollowing($profile): bool
    {
        return Follow::whereProfileId($this->id)->whereFollowingId($profile->id)->exists();
    }

    public function isFollowedBy($profile): bool
    {
        return Follow::whereProfileId($profile->id)->whereFollowingId($this->id)->exists();
    }

    public function avatar()
    {
        return $this->hasOne(Avatar::class)->withDefault([
            'media_path' => 'public/avatars/default.jpg',
            'change_count' => 0,
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

    public function getSearchResult(): SearchResult
    {
        $url = $this->urlLink();

        return new SearchResult($this, $this->name, $url);
    }
}
