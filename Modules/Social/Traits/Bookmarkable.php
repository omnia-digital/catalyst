<?php

namespace Modules\Social\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;
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

    public function isBookmarked(): bool
    {
        return $this->bookmarks->isNotEmpty();
    }

    public function markAsBookmark(): self
    {
        $this->bookmarks()->create([
            'user_id' => Auth::id(),
            'team_id' => Auth::user()->currentTeam->id
        ]);

        return $this;
    }

    public function removeBookmark(): self
    {
        $this->bookmarks()->delete();

        return $this;
    }
}
