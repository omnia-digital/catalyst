<?php

    namespace Modules\Social\Traits;

    use Illuminate\Database\Eloquent\Relations\MorphMany;
    use Modules\Social\Models\Bookmark;

    trait Bookmarkable
    {
        /**
         * Get the bookmarks that all Users have created for this model
         *
         * @return MorphMany
         */
        public function bookmarks(): MorphMany
        {
            return $this->morphMany(Bookmark::class, 'bookmarkable');
        }
    }
