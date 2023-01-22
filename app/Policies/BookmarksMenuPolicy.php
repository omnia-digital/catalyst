<?php

namespace App\Policies;

use App\Models\User;
use STAFEGROUPAB\FilamentBookmarksMenu\Models\BookmarksMenu;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookmarksMenuPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('view_any_bookmarks::menu');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \STAFEGROUPAB\FilamentBookmarksMenu\Models\BookmarksMenu  $bookmarksMenu
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, BookmarksMenu $bookmarksMenu)
    {
        return $user->can('view_bookmarks::menu');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create_bookmarks::menu');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \STAFEGROUPAB\FilamentBookmarksMenu\Models\BookmarksMenu  $bookmarksMenu
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, BookmarksMenu $bookmarksMenu)
    {
        return $user->can('update_bookmarks::menu');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \STAFEGROUPAB\FilamentBookmarksMenu\Models\BookmarksMenu  $bookmarksMenu
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, BookmarksMenu $bookmarksMenu)
    {
        return $user->can('delete_bookmarks::menu');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(User $user)
    {
        return $user->can('delete_any_bookmarks::menu');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \STAFEGROUPAB\FilamentBookmarksMenu\Models\BookmarksMenu  $bookmarksMenu
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, BookmarksMenu $bookmarksMenu)
    {
        return $user->can('force_delete_bookmarks::menu');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDeleteAny(User $user)
    {
        return $user->can('force_delete_any_bookmarks::menu');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \STAFEGROUPAB\FilamentBookmarksMenu\Models\BookmarksMenu  $bookmarksMenu
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, BookmarksMenu $bookmarksMenu)
    {
        return $user->can('restore_bookmarks::menu');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(User $user)
    {
        return $user->can('restore_any_bookmarks::menu');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \STAFEGROUPAB\FilamentBookmarksMenu\Models\BookmarksMenu  $bookmarksMenu
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(User $user, BookmarksMenu $bookmarksMenu)
    {
        return $user->can('replicate_bookmarks::menu');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reorder(User $user)
    {
        return $user->can('reorder_bookmarks::menu');
    }

}
