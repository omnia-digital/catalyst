<?php

namespace Modules\Social\Traits;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Auth;
use Modules\Social\Models\Bookmark;

trait Bookmarkable
{
    /**
     * Get the bookmarks that all Users have created for this model
     *
     * @psalm-return \Illuminate\Database\Eloquent\Relations\MorphMany<\Modules\Social\Models\Bookmark>
     */
    public function bookmarks(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }

    public function isBookmarkedBy(User|Authenticatable|null $user = null): bool
    {
        is_null($user) && $user = Auth::user();

        return $this->bookmarks->where('user_id', $user->id)->isNotEmpty();
    }

    public function markAsBookmark(): \Modules\Social\Models\Post
    {
        $this->bookmarks()->create([
            'user_id' => Auth::id(),
            'team_id' => Auth::user()->currentTeam->id
        ]);

        return $this;
    }

    public function removeBookmark(): \Modules\Social\Models\Post
    {
        $this->bookmarks()->where('user_id', Auth::id())->delete();

        return $this;
    }
}
