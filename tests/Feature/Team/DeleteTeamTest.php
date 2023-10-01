<?php

namespace Tests\Feature\Team;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\DeleteTeamForm;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteTeamTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function teams_can_be_deleted()
    {
        $this->actingAs($user = User::factory()->withTeam()->create());

        $team = $user->teams()->first();

        $component = Livewire::test(DeleteTeamForm::class, ['team' => $team->fresh()])
            ->call('deleteTeam');

        $this->assertNull($team->fresh());
        $this->assertCount(0, $user->fresh()->teams);
    }
}
