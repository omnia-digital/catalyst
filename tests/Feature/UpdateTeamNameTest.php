<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\UpdateTeamNameForm;
use Livewire\Livewire;
use Modules\Social\Models\Profile;
use Tests\TestCase;

class UpdateTeamNameTest extends TestCase
{
    use RefreshDatabase;

    public $user;
    public $otherUser;

    protected function setUp(): void
    {
        parent::setUp();
    
        $this->actingAs($user = User::factory()->withTeam()->create([
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

        $this->user = $user;
    }

    public function test_team_names_can_be_updated()
    {
        $team = $this->user->teams()->first();

        Livewire::test(UpdateTeamNameForm::class, ['team' => $team])
                    ->set(['state' => ['name' => 'Test Team']])
                    ->call('updateTeamName');

        $this->assertCount(1, $this->user->fresh()->ownedTeams);
        $this->assertEquals('Test Team', $team->fresh()->name);
    }
}
