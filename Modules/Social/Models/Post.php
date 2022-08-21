<?php

namespace Modules\Social\Models;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Social\Database\Factories\PostFactory;
use Modules\Social\Enums\PostType;
use Modules\Social\Traits\Attachable;
use Modules\Social\Traits\Bookmarkable;
use Modules\Social\Traits\Likable;
use Modules\Social\Traits\Postable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;

class Post extends Model implements HasMedia
{
    use HasFactory, Likable, Postable, Attachable, Bookmarkable, InteractsWithMedia, HasTags;

    /**
     * @var string[]
     *
     * @psalm-var array{0: 'user_id', 1: 'team_id', 2: 'title', 3: 'type', 4: 'body', 5: 'postable_id', 6: 'postable_type', 7: 'repost_original_id', 8: 'published_at', 9: 'image'}
     */
    protected $fillable = [
        'user_id',
        'team_id',
        'title',
        'type',
        'body',
        'postable_id',
        'postable_type',
        'repost_original_id',
        'published_at',
        'image'
    ];

    /**
     * @var string[]
     *
     * @psalm-var array{0: 'published_at'}
     */
    protected $dates = [
        'published_at'
    ];

    /**
     * @var string[]
     *
     * @psalm-var array{0: 'published_at'}
     */
    protected $appends = [
        'published_at',
    ];

    protected static function booted()
    {
        // @NOTE - this is so we don't accidentally pull in comments when we are trying to just get regular posts
        static::addGlobalScope('parent', function (Builder $builder) {
            $builder->whereNull('postable_id');
        });
    }

    protected static function newFactory(): PostFactory
    {
        return PostFactory::new();
    }
}
