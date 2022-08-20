<?php

    namespace Modules\Social\Traits;

    use Illuminate\Database\Eloquent\Relations\MorphMany;
    use Modules\Social\Models\Bookmark;

    trait HasBookmarks
    {
        /**
         * Get the bookmarks that User has created
         *
         * @return MorphMany
         */
        public function bookmarks(): MorphMany
        {
            return $this->morphMany(Bookmark::class, 'bookmarkable');
        }

        public function createBookmark($model, $modelId, $order = null, $userId = null, $teamId = null, ): \Illuminate\Database\Eloquent\Model
        {
            return $this->bookmarks()->create([
                'user_id'   => $userId ?? $this->id,
                'team_id'   => $teamId,
                'bookmarkable_type' => $model,
                'bookmarkable_id' => $modelId
            ]);
        }
    }
