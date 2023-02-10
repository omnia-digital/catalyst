<?php

use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Modules\Social\Models\Profile;

test('Social profile show profile info', function () {
    $this->actingAs($user = User::factory()->create());

    $profile = new Profile([
                        'first_name'       => 'test first name',
                        'last_name'       => 'test last name',
                        'bio'        => 'test bio',
                        'remote_url' => 'http://test.url/',
                        'location'   => 'test location',
                    ]);
    $user->profile()->save($profile);

    $response = $this->get('/u/' . $profile->handle);

    $response->assertStatus(200);
});
