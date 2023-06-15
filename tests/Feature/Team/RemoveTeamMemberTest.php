<?php

namespace Tests\Feature\Team;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Modules\Social\Http\Livewire\Pages\Teams\Admin\ManageTeamMembers;
use Modules\Social\Models\Profile;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RemoveTeamMemberTest extends TestCase
{
    use RefreshDatabase;

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
    public function team_members_can_be_removed_from_teams()
    {
        $team = $this->user->teams()->first();

        $team->users()->attach(
            $this->otherUser, ['role_id' => Role::findOrCreate('admin')->id]
        );

        Livewire::test(ManageTeamMembers::class, ['team' => $team])
            ->set('teamMemberIdBeingRemoved', $this->otherUser->id)
            ->call('removeTeamMember');

        $this->assertCount(0, $team->fresh()->members);
    }

    /**
     * @test
     */
    public function only_team_owner_can_remove_team_members()
    {
        $team = $this->user->teams()->first();

        $team->users()->attach(
            $this->otherUser, ['role_id' => Role::findOrCreate('admin')->id]
        );

        $this->actingAs($this->otherUser);

        Livewire::test(ManageTeamMembers::class, ['team' => $team])
            ->set('teamMemberIdBeingRemoved', $this->user->id)
            ->call('removeTeamMember')
            ->assertStatus(403);
    }
}
