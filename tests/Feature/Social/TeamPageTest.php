<?php

namespace Tests\Feature\Social;

use App\Http\Livewire\Teams\CreateTeamModal;
use App\Models\Location;
use App\Models\Tag;
use App\Models\Team;
use App\Models\User;
use App\Support\Platform\Platform;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Livewire\Livewire;
use Modules\Social\Models\Profile;
use Tests\TestCase;

class TeamPageTest extends TestCase
{
    use RefreshDatabase, WithFaker;

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

    public function test_load_teams_page()
    {
        $response = $this->get('/social/' . Platform::getTeamsWord());

        $response->assertStatus(200);
    }

    public function test_load_team_profile_page()
    {
        $team = Team::factory()
            ->has(Location::factory(1))
            ->withUsers(1, config('platform.teams.default_owner_role'))
            ->create();

            
        $response = $this->get('/'. Platform::getTeamsLetter() . '/' . $team->handle);

        $response->assertStatus(200);
    }

    public function test_create_team()
    {
        Livewire::test(CreateTeamModal::class)
            ->set('name', 'This is a Test Team')
            ->call('create');

        $this->assertTrue(Team::where('name', 'This is a Test Team')->exists());
    }
}
