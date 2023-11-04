<?php

namespace Tests\Feature\Admin;

use App\Actions\Teams\CreateTeam;
use App\Filament\Resources\AwardResource\Pages\ListAwards;
use App\Filament\Resources\Shield\RoleResource\Pages\ListRoles;
use App\Filament\Resources\TagResource\Pages\ListTag;
use App\Filament\Resources\TeamResource\Pages\ListTeams;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use OmniaDigital\CatalystCore\Filament\Resources\AwardResource\Pages\ListAwards;
use OmniaDigital\CatalystCore\Models\Award;
use OmniaDigital\CatalystCore\Models\Profile;
use Tests\TestCase;
use OmniaDigital\CatalystCore\Models\Role;

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
        ]);

        Role::create(['name' => 'super-admin']);
        $this->user->assignRole('super-admin');

        $profile = new Profile([
            'first_name' => 'test first name',
            'last_name' => 'test last name',
            'bio' => 'test bio',
            'remote_url' => 'http://test.url/',
            'location' => 'test location',
        ]);

        (new CreateTeam)->create($this->user, [
            'name' => 'test admin team',
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

        Livewire::test(ListUsers::class)
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

        Livewire::test(ListRoles::class)
            ->assertSuccessful();
    }

    /**
     * @test
     */
    public function can_render_tag_resource_page()
    {
        $this->actingAs($this->user);

        $tags = Tag::factory(10)->create();

        Livewire::test(ListTag::class)
            ->assertSuccessful();
    }

    /**
     * @test
     */
    public function can_render_awards_resource_page()
    {
        $this->actingAs($this->user);

        $awards = Award::factory(10)->create();

        Livewire::test(ListAwards::class)
            ->assertSuccessful();
    }

    /**
     * @test
     */
//    public function can_render_team_resource_page()
//    {
//        // @TODO [Josh] - not passing
//        $this->actingAs($this->user);
//
//        $teams = Team::factory(10)
//            ->has(Location::factory(1))
//            ->withUsers(1, config('platform.teams.default_owner_role'))
//            ->withUsers(2, config('platform.teams.default_member_role'))
//            ->create();
//
//        Livewire::test(ListTeams::class)
//            ->assertSuccessful();
//    }
}
