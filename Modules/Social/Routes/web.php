<?php

use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController;
use Modules\Social\Http\Livewire\Home;
use Modules\Social\Http\Livewire\Pages\Bookmarks\Index;
use Modules\Social\Http\Livewire\Pages\Posts\Show as ShowPosts;
use Modules\Social\Http\Livewire\Pages\Profiles\Show as ShowProfile;
use Modules\Social\Http\Livewire\Pages\Contacts\Index as ContactsIndex;
use Modules\Social\Http\Livewire\Pages\Discover\Index as DiscoverIndex;
use Modules\Social\Http\Livewire\Pages\Profiles\Edit as EditProfile;
use Modules\Social\Http\Livewire\Pages\Profiles\Followers as ProfileFollowers;
use Modules\Social\Http\Livewire\Pages\Projects\Awards as ProjectAwards;
use Modules\Social\Http\Livewire\Pages\Projects\Edit as EditProject;
use Modules\Social\Http\Livewire\Pages\Projects\Followers as ProjectFollowers;
use Modules\Social\Http\Livewire\Pages\Projects\Members as ProjectMembers;
use Modules\Social\Http\Livewire\Pages\Projects\Show as ShowProject;
use Modules\Social\Http\Livewire\Pages\Projects\MyProjects;

Route::name('social.')->prefix('social')->middleware(['auth', 'verified'])->group(function () {
    //        Route::get('/', 'SocialController@index');

    // the way twitter works is
    // /{handle} for profile
    // /{handle}/status/{post_id} for any type of post, whether it's a post or reply
    // /{messages}/{message_id} for messages

    Route::get('/home', Home::class)->name('home');
    Route::get('bookmarks', Index::class)->name('bookmarks');

    Route::get('/discover', DiscoverIndex::class)->name('discover');

    Route::name('profile.')->prefix('profiles')->group(function() {
        Route::get('{profile:handle}', ShowProfile::class)->name('show');
        Route::get('{profile:handle}/edit', EditProfile::class)->can('update-profile', 'profile')->name('edit');
        Route::get('{profile:handle}/media', function() {})->name('media');
        Route::get('{profile:handle}/followers', ProfileFollowers::class)->name('followers');
    });

    Route::name('projects.')->prefix('projects')->middleware(['auth','verified'])->group(function () {
        Route::get('{team}', ShowProject::class)->name('show');
        Route::get('{team}/edit', EditProject::class)->can('update-team', 'team')->name('edit');
        Route::get('{team}/members', ProjectMembers::class)->name('members');
        Route::get('{team}/followers', ProjectFollowers::class)->name('followers');
        Route::get('{team}/awards', ProjectAwards::class)->name('awards');
    });

    Route::get('/my-projects', MyProjects::class)->name('my-projects');

    Route::get('/posts/{post}', ShowPosts::class)->name('posts.show');

    Route::name('contacts.')->prefix('contacts')->group(function () {
        Route::get('/', ContactsIndex::class)->name('index');
    });

    Route::get('/crm', function () {
        return "CRM";
    })->name('crm');

    Route::get('/learn', function () {
        return "Learn";
    })->name('learn');

    Route::get('/marketplace', function () {
        return "Marketplace";
    })->name('marketplace');
    //        Route::get('/', function () {
    ////            return Inertia::render('Social/Home');
    //        })->name('social-home');
    //        Route::get('/explore', function () {
    //        })->name('explore');
    //        Route::get('/profile', [Profile::class, 'show'])->name('profile');
    //        Route::get('/bookmarks', function () {
    //        })->name('bookmarks');
});

