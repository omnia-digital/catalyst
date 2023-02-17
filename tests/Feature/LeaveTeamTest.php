<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Modules\Social\Http\Livewire\Pages\Teams\Admin\ManageTeamMembers;
use Modules\Social\Models\Profile;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class LeaveTeamTest extends TestCase
{
    use RefreshDatabase;

    public $user;

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

    public function test_users_can_leave_teams()
    {
        $team = $this->user->teams()->first();
        
        $team->users()->attach(
            $otherUser = User::factory()->create(), ['role_id' => Role::findOrCreate('admin')->id]
        );

        $otherUser->profile()->save(new Profile([
            'first_name'       => 'other user first name',
            'last_name'       => 'other user last name',
            'bio'        => 'other user bio',
            'remote_url' => 'http://otheruser.url/',
            'location'   => 'other user location',
        ]));

        $this->actingAs($otherUser);

        Livewire::test(ManageTeamMembers::class, ['team' => $team])
                    ->call('leaveTeam');

        $this->assertCount(1, $team->fresh()->users);
    }

    public function test_team_owners_cant_leave_their_own_team()
    {
        $team = $this->user->teams()->first();

        Livewire::test(ManageTeamMembers::class, ['team' => $team])
                    ->call('leaveTeam')
                    ->assertHasErrors(['team']);

        $this->assertNotNull($team->fresh());
        $this->assertEquals($this->user->id, $team->owner->id);
    }
}
