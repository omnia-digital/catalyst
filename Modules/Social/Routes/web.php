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
use Modules\Social\Http\Livewire\Pages\Profiles\Media as ProfileMedia;
use App\Http\Livewire\Pages\Teams\Discover as DiscoverTeams;
use App\Http\Livewire\Pages\Teams\Index as AllTeams;
use Modules\Social\Http\Livewire\Pages\Profiles\Awards as ProfileAwards;
use Modules\Social\Http\Livewire\Pages\Teams\Awards as TeamAwards;
use Modules\Social\Http\Livewire\Pages\Teams\Calendar as TeamCalendar;
use Modules\Social\Http\Livewire\Pages\Teams\Edit as EditTeam;
use Modules\Social\Http\Livewire\Pages\Teams\Followers as TeamFollowers;
use Modules\Social\Http\Livewire\Pages\Teams\Members as TeamMembers;
use Modules\Social\Http\Livewire\Pages\Teams\Show as ShowTeam;
use Modules\Social\Http\Livewire\Pages\Teams\MyTeams;


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
        Route::get('{profile}', ShowProfile::class)->name('show');
        Route::get('{profile}/edit', EditProfile::class)->name('edit');
        Route::get('{profile}/media', ProfileMedia::class)->name('media');
        Route::get('{profile}/followers', ProfileFollowers::class)->name('followers');
        Route::get('{profile}/awards', ProfileAwards::class)->name('awards');
    });

    Route::name('teams.')->prefix(\Trans::get('teams'))->middleware(['auth', 'verified'])->group(function () {
        Route::get('/discover', DiscoverTeams::class)->name('discover');
        Route::get('/calendar', TeamCalendar::class)->name('calendar');
        Route::get('/my-' . \Trans::get('teams'), MyTeams::class)->name('my-teams');
        Route::get('{team}', ShowTeam::class)->name('show');
        Route::get('{team}/edit', EditTeam::class)->name('edit');
        Route::get('{team}/members', TeamMembers::class)->name('members');
        Route::get('{team}/followers', TeamFollowers::class)->name('followers');
        Route::get('{team}/awards', TeamAwards::class)->name('awards');
        Route::get('/', AllTeams::class)->name('home');
    });

    Route::get('/posts/{post}', ShowPosts::class)->name('posts.show');

    Route::name('contacts.')->prefix('contacts')->group(function () {
        Route::get('/', ContactsIndex::class)->name('index');
    });

    Route::get('/crm', \Modules\Social\Http\Livewire\Pages\Crm\Index::class)->name('crm');

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

