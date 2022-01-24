<?php

use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

test('Social profile show profile info', function () {
    $this->actingAs($user = User::factory()->create());

    $profile = new \App\Models\Profile([
                                           'name'       => 'test name',
                                           'bio'        => 'test bio',
                                           'remote_url' => 'http://test.url/',
                                           'location'   => 'test location',
                                       ]);
    $user->profile()->save($profile);

    $response = $this->get('/social/profile');

    $response->assertStatus(200);
});
