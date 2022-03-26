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

class Post extends Model implements HasMedia
{
    use HasFactory, Likable, Postable, Attachable, Bookmarkable, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'team_id',
        'title',
        'type',
        'body',
        'postable_id',
        'postable_type',
        'image'
    ];

    protected static function booted()
    {
        static::addGlobalScope('parent', function (Builder $builder) {
            $builder->whereNull('postable_id');
        });
    }

    public function type(): Attribute
    {
        return Attribute::make(
            get: fn($value) => PostType::tryFrom($value),
            set: fn($value) => $value?->value
        );
    }

    protected static function newFactory()
    {
        return PostFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function postable(): MorphTo
    {
        return $this->morphTo();
    }

    public function attachMedia(array $mediaUrls): self
    {
        /** @var string $mediaUrl */
        foreach ($mediaUrls as $mediaUrl) {
            $this->addMediaFromUrl($mediaUrl)->toMediaCollection();
        }

        return $this;
    }
}
