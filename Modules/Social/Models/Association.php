<?php

    namespace Modules\Social\Models;

    use App\Models\NullMedia;
    use App\Models\User;
    use App\Support\Lexer\PrettyNumber;
use App\Traits\Tag\HasProfileTags;
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
    use Squire\Models\Country;

    class Association extends Model
    {
        protected $fillable = [
            'target_type',
            'target_id',
            'associatable_type',
            'associatable_id',
        ];

        public function associatable()
        {
            $this->morphTo();
        }
    }
