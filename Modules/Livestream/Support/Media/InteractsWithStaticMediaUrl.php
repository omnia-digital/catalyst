<?php

namespace Modules\Livestream\Support\Media;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Livestream\Models\Media;

trait InteractsWithStaticMediaUrl
{
    public function staticMedia(): MorphMany
    {
        return $this
            ->morphMany(config('media-library.media_model'), 'model')
            ->withoutGlobalScope('notStaticMedia')
            ->where('is_static', 1);
    }

    public function getMediaWithStaticUrl(): Collection
    {
        return self::media()
            ->withoutGlobalScope('notStaticMedia')
            ->get();
    }

    public function getStaticUrlMediaOnly(): Collection
    {
        return self::media()
            ->withoutGlobalScope('notStaticMedia')
            ->where('is_static', 1)
            ->get();
    }

    public function saveStaticUrl(string $staticUrl, ?string $name = null, ?string $mimeType = null): Media
    {
        return $this->media()->create([
            'file_name' => $staticUrl,
            'name' => $name ?? $staticUrl,
            'collection_name' => 'default',
            'disk' => '',
            'size' => 0,
            'mime_type' => $mimeType,
            'manipulations' => [],
            'custom_properties' => [],
            'generated_conversions' => [],
            'responsive_images' => [],
            'is_static' => 1,
        ]);
    }
}
