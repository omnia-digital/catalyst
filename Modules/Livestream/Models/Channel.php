<?php

namespace Modules\Livestream\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Channel extends Model
{
    use HasFactory, HasSlug;

    protected $guarded = [];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->doNotGenerateSlugsOnUpdate()
            ->saveSlugsTo('slug');
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function livestreamAccount(): BelongsTo
    {
        return $this->belongsTo(LivestreamAccount::class);
    }
}
