<?php

namespace Tests\Feature;

use App\Filament\Resources\AwardResource;
use App\Filament\Resources\TagResource;
use App\Filament\Resources\TeamResource;
use App\Filament\Resources\UserResource;
use App\Models\Award;
use App\Models\Location;
use App\Models\Tag;
use App\Models\Team;
use App\Models\User;
use BezhanSalleh\FilamentShield\Resources\RoleResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Modules\Social\Models\Profile;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        $this->user = User::factory()->create([
            'email' => 'test@omniadigital.io',
            'is_admin' => true,
        ]);

        $profile = new Profile([
            'first_name' => 'test first name',
            'last_name' => 'test last name',
            'bio' => 'test bio',
            'remote_url' => 'http://test.url/',
            'location' => 'test location',
        ]);

        $this->user->profile()->save($profile);
    }

    /**
     * @test
     */
    public function loading_admin_login_page()
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function can_render_user_resource_page()
    {
        $this->actingAs($this->user);
        //$users = User::factory(10)->withProfile()->create();

        Livewire::test(UserResource\Pages\ListUsers::class)
            ->assertSuccessful();
    }

    /**
     * @test
     */
    public function can_render_role_resource_page()
    {
        $this->actingAs($this->user);

        $teams = Team::factory(10)
            ->has(Location::factory(1))
            ->withUsers(1, config('platform.teams.default_owner_role'))
            ->withUsers(2, config('platform.teams.default_member_role'))
            ->create();

        Livewire::test(RoleResource\Pages\ListRoles::class)
            ->assertSuccessful();
    }

    /**
     * @test
     */
    public function can_render_tag_resource_page()
    {
        $this->actingAs($this->user);

        $tags = Tag::factory(10)->create();

        Livewire::test(TagResource\Pages\ListTag::class)
            ->assertSuccessful();
    }

    /**
     * @test
     */
    public function can_render_awards_resource_page()
    {
        $this->actingAs($this->user);

        $awards = Award::factory(10)->create();

        Livewire::test(AwardResource\Pages\ListAwards::class)
            ->assertSuccessful();
    }

    /**
     * @test
     */
    public function can_render_team_resource_page()
    {
        $this->actingAs($this->user);

        $teams = Team::factory(10)
            ->has(Location::factory(1))
            ->withUsers(1, config('platform.teams.default_owner_role'))
            ->withUsers(2, config('platform.teams.default_member_role'))
            ->create();

        Livewire::test(TeamResource\Pages\ListTeams::class)
            ->assertSuccessful();
    }
}
