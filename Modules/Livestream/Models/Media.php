<?php

namespace Modules\Livestream\Models;

use Modules\Livestream\Traits\Downloadable;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\MediaCollections\Models\Media as SpatieMedia;

class Media extends SpatieMedia
{
    use Downloadable;
    
    protected static function booted()
    {
        static::addGlobalScope('notStaticMedia', function (Builder $builder) {
            $builder->where('is_static', 0);
        });
    }

    public function isStatic(): bool
    {
        return (bool)$this->is_static;
    }

    public function getStaticUrl(): ?string
    {
        if (!$this->isStatic()) {
            return null;
        }

        return $this->file_name;
    }

}
