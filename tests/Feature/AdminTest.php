<?php

namespace Tests\Feature;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Social\Models\Profile;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    /* protected function setUp(): void
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
    } */

   /*  public function test_loading_admin_login_page()
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
    }

    public function test_loading_admin_home_page()
    {
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

        $response = $this->get('/admin');

        $response->assertSuccessful();
    }

    public function test_can_render_user_resource_page()
    {
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

        $this->get(UserResource::getUrl('index'))->assertSuccessful();
    } */
}
