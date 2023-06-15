<?php

namespace Tests\Feature\Team;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Laravel\Jetstream\Mail\TeamInvitation;
use Livewire\Livewire;
use Modules\Social\Http\Livewire\Pages\Teams\Admin\ManageTeamMembers;
use Modules\Social\Models\Profile;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class InviteTeamMemberTest extends TestCase
{
    use RefreshDatabase;

    public $user;

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
    }

    /**
     * @test
     */
    public function team_members_can_be_invited_to_team()
    {
        Mail::fake();

        $team = $this->user->teams()->first();

        $role = Role::create([
            'team_id' => $team->id,
            'name' => 'admin',
        ]);

        $component = Livewire::test(ManageTeamMembers::class, ['team' => $team])
            ->set('addTeamMemberForm', [
                'email' => 'test@example.com',
                'role' => $role->name,
                'message' => 'Please join the team',
            ])->call('addTeamMember');

        Mail::assertSent(TeamInvitation::class);

        $this->assertCount(1, $team->fresh()->teamInvitations);
    }

    /**
     * @test
     */
    public function team_member_invitations_can_be_cancelled()
    {
        $team = $this->user->teams()->first();

        $role = Role::create([
            'team_id' => $team->id,
            'name' => 'admin',
        ]);

        // Add the team member...
        $component = Livewire::test(ManageTeamMembers::class, ['team' => $team])
            ->set('addTeamMemberForm', [
                'email' => 'test@example.com',
                'role' => $role->name,
                'message' => 'Please join the team',
            ])->call('addTeamMember');

        $invitationId = $team->fresh()->teamInvitations->first()->id;

        // Cancel the team invitation...
        $component->call('cancelTeamInvitation', $invitationId);

        $this->assertCount(0, $team->fresh()->teamInvitations);
    }
}
