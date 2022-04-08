<?php

namespace Modules\Social\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Auth;
use Modules\Social\Models\Bookmark;

trait Bookmarkable
{
    /**
     * Get the bookmarks that all Users have created for this model
     */
    public function bookmark(): MorphOne
    {
        return $this->morphOne(Bookmark::class, 'bookmarkable');
    }

    public function isBookmarked(): bool
    {
        return (bool)$this->bookmark;
    }

    public function markAsBookmark(): self
    {
        $this->bookmark()->create([
            'user_id' => Auth::id(),
            'team_id' => Auth::user()->currentTeam->id
        ]);

        return $this;
    }

    public function removeBookmark(): self
    {
        $this->bookmark()->delete();

        return $this;
    }
}
