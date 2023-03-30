<?php

namespace Tests\Feature\Social;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Social\Models\Profile;
use Platform;
use Tests\TestCase;

class NavigationPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs($user = User::factory()->create([
            'email' => 'test@omniadigital.io',
            'is_admin' => true,
        ]));

        $profile = new Profile([
            'first_name' => 'test first name',
            'last_name' => 'test last name',
            'bio' => 'test bio',
            'remote_url' => 'http://test.url/',
            'location' => 'test location',
        ]);

        $user->profile()->save($profile);
    }

    /**
     * @test
     */
    public function load_home_page()
    {
        $response = $this->get('/social/home');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function load_discover_page()
    {
        $response = $this->get('/social/' . Platform::getTeamsWord() . '/discover');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function load_teams_page()
    {
        $response = $this->get('/social/' . Platform::getTeamsWord());

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function load_news_page()
    {
        $response = $this->get('/games/feeds');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function load_resources_page()
    {
        $response = $this->get('/resources');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function load_bookmarks_page()
    {
        $response = $this->get('/social/bookmarks');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function load_notifications_page()
    {
        $response = $this->get('/notifications');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function load_account_page()
    {
        $response = $this->get('/account');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function load_billing_page()
    {
        $response = $this->get('/billing/billing');

        $response->assertStatus(200);
    }
}
