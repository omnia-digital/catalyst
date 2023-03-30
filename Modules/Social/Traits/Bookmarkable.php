<?php

namespace Modules\Social\Traits;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Social\Models\Bookmark;

trait Bookmarkable
{
    /**
     * Get the bookmarks that all Users have created for this model
     */
    public function bookmarks(): MorphMany
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }

    public function isBookmarkedBy(User|Authenticatable|null $user = null): bool
    {
        is_null($user) && $user = auth()->user();

        return $this->bookmarks->where('user_id', $user?->id)->isNotEmpty();
    }

    public function markAsBookmark(): self
    {
        $this->bookmarks()->create([
            'user_id' => auth()->id(),
            'team_id' => auth()->user()->currentTeam->id,
        ]);

        return $this;
    }

    public function removeBookmark(): self
    {
        $this->bookmarks()->where('user_id', auth()->id())->delete();

        return $this;
    }
}
