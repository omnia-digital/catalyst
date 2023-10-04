<?php

namespace Tests\Feature\Social;

use App\Livewire\Teams\CreateTeamModal;
use App\Models\Location;
use App\Models\Tag;
use App\Models\Team;
use App\Models\User;
use OmniaDigital\CatalystCore\Facades\Catalyst;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Modules\Social\Models\Profile;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class TeamPageTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public $user;
    public $otherUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs($user = User::factory()->withTeam()->create([
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

        $this->user = $user;

        $otherUser = User::factory()->create();

        $otherUser->profile()->save(new Profile([
            'first_name' => 'other user first name',
            'last_name' => 'other user last name',
            'bio' => 'other user bio',
            'remote_url' => 'http://otheruser.url/',
            'location' => 'other user location',
        ]));

        $this->otherUser = $otherUser;
    }

    /**
     * @test
     */
    public function load_teams_page()
    {
        $response = $this->get('/social/' . Catalyst::getTeamsWord());

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function load_team_profile_page()
    {
        $team = Team::factory()
            ->has(Location::factory(1))
            ->withUsers(1, config('platform.teams.default_owner_role'))
            ->create();

        $response = $this->get('/' . Catalyst::getTeamsLetter() . '/' . $team->handle);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function create_team()
    {
        $tag = Tag::findOrCreate('testType', 'team_type');

        Livewire::test(CreateTeamModal::class)
            ->set('name', 'This is a Test Team')
            ->set('teamTypes', [$tag->name => ucwords($tag->name)])
            ->call('create');

        $this->assertTrue(Team::where('name', 'This is a Test Team')->exists());
    }

    /**
     * @test
     */
    public function team_owner_can_access_team_admin_page()
    {
        $team = $this->user->teams()->first();

        $response = $this->get('/social/' . Catalyst::getTeamsWord() . '/' . $team->handle . '/admin');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function team_members_cannot_access_team_admin_page()
    {
        $team = $this->user->teams()->first();

        $team->users()->attach(
            $this->otherUser, ['role_id' => Role::findOrCreate('member')->id]
        );

        $this->actingAs($this->otherUser);

        $response = $this->get('/social/' . Catalyst::getTeamsWord() . '/' . $team->handle . '/admin');

        $response->assertStatus(403);
    }
}
