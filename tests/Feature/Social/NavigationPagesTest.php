<?php

namespace Tests\Feature\Social;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Social\Models\Profile;
use Tests\TestCase;

class NavigationPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    
        $this->actingAs($user = User::factory()->create([
            'email' => 'test@omniadigital.io',
            'is_admin' => true
        ]));

        $profile = new Profile([
            'first_name'       => 'test first name',
            'last_name'       => 'test last name',
            'bio'        => 'test bio',
            'remote_url' => 'http://test.url/',
            'location'   => 'test location',
        ]);

        $user->profile()->save($profile);
    }

    public function test_load_home_page()
    {
        $response = $this->get('/social/home');

        $response->assertStatus(200);
    }

    public function test_load_discover_page()
    {
        $response = $this->get('/social/teams/discover');

        $response->assertStatus(200);
    }

    public function test_load_teams_page()
    {
        $response = $this->get('/social/teams');

        $response->assertStatus(200);
    }

    public function test_load_news_page()
    {
        $response = $this->get('/games/feeds');

        $response->assertStatus(200);
    }

    public function test_load_resources_page()
    {
        $response = $this->get('/resources');

        $response->assertStatus(200);
    }

    public function test_load_bookmarks_page()
    {
        $response = $this->get('/social/bookmarks');

        $response->assertStatus(200);
    }

    public function test_load_notifications_page()
    {
        $response = $this->get('/notifications');

        $response->assertStatus(200);
    }

    public function test_load_account_page()
    {
        $response = $this->get('/account');

        $response->assertStatus(200);
    }

    public function test_load_billing_page()
    {
        $response = $this->get('/billing/billing');

        $response->assertStatus(200);
    }
}
