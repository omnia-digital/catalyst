<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class MediaFile extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
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
