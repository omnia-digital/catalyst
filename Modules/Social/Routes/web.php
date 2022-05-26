<?php

use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController;
use Modules\Social\Http\Livewire\Home;
use Modules\Social\Http\Livewire\Pages\Bookmarks\Index;
use Modules\Social\Http\Livewire\Pages\Posts\Show as ShowPosts;
use Modules\Social\Http\Livewire\Pages\Profiles\Show as ShowProfile;
use Modules\Social\Http\Livewire\Pages\Contacts\Show as ShowContacts;
use Modules\Social\Http\Livewire\Pages\Projects\Edit as EditProject;
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

    //        Route::get('/projects', function () {
    //            return "Projects";
    //        })->name('projects');

    Route::name('profile.')->prefix('profiles')->group(function() {
        Route::get('{profile:handle}', ShowProfile::class)->name('show');
    });

    Route::name('projects.')->prefix('projects')->middleware(['auth','verified'])->group(function () {
        Route::get('{team}', ShowProject::class)->name('show');
        Route::get('{team}/edit', EditProject::class)->name('edit');
        Route::get('{team}/members', ProjectMembers::class)->name('members');
        Route::get('{team}/followers', ProjectMembers::class)->name('followers');
    });

    Route::get('/my-projects', MyProjects::class)->name('my-projects');

    Route::get('/posts/{post}', ShowPosts::class)->name('posts.show');

    Route::name('contacts.')->prefix('contacts')->group(function () {
        Route::get('/', ShowContacts::class)->name('show');
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

