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

        /**
         * @var false
         */
        public bool $incrementing = false;

        /**
         * @var string[]
         *
         * @psalm-var array{0: 'deleted_at', 1: 'last_fetched_at'}
         */
        protected array $dates = [
            'deleted_at',
            'last_fetched_at'
        ];

        /**
         * @var string[]
         *
         * @psalm-var array{0: 'private_key'}
         */
        protected array $hidden = ['private_key'];

        /**
         * @var string[]
         *
         * @psalm-var array{0: 'id', 1: 'first_name', 2: 'last_name', 3: 'handle', 4: 'bio', 5: 'website', 6: 'user_id'}
         */
        protected array $visible = [
            'id',
            'first_name',
            'last_name',
            'handle',
            'bio',
            'website',
            'user_id',
        ];

        /**
         * @var string[]
         *
         * @psalm-var array{0: 'first_name', 1: 'last_name', 2: 'bio', 3: 'website', 4: 'user_id'}
         */
        protected array $fillable = [
            'first_name',
            'last_name',
            'bio',
            'website',
            'user_id',
        ];

        /**
         * @var string[]
         *
         * @psalm-var array{0: 'name', 1: 'profile_photo_url'}
         */
        protected array $appends = [
            'name',
            'profile_photo_url'
        ];

        /**
         * Get the route key for the model.
         *
         * @return string
         *
         * @psalm-return 'handle'
         */
        public function getRouteKeyName()
        {
            return 'handle';
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
         * Advice
         */
    }
