<?php

namespace Tests\Feature\Team;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\CreateTeamForm;
use Livewire\Livewire;
use Modules\Social\Models\Profile;
use Tests\TestCase;

class CreateTeamTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function teams_can_be_created()
    {
        $this->actingAs($user = User::factory()->withTeam()->create());

        $profile = new Profile([
            'first_name' => 'test first name',
            'last_name' => 'test last name',
            'bio' => 'test bio',
            'remote_url' => 'http://test.url/',
            'location' => 'test location',
        ]);

        $user->profile()->save($profile);

        Livewire::test(CreateTeamForm::class)
            ->set(['state' => ['name' => 'Test Team']])
            ->call('createTeam');

        $this->assertCount(2, $user->fresh()->ownedTeams);
        $this->assertEquals('Test Team', $user->fresh()->ownedTeams()->latest('id')->first()->name);
    }
}
