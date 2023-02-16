<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Modules\Social\Http\Livewire\Pages\Teams\Admin\ManageTeamMembers;
use Modules\Social\Models\Profile;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UpdateTeamMemberRoleTest extends TestCase
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

        $otherUser = User::factory()->create();

        $otherUser->profile()->save(new Profile([
            'first_name'       => 'other user first name',
            'last_name'       => 'other user last name',
            'bio'        => 'other user bio',
            'remote_url' => 'http://otheruser.url/',
            'location'   => 'other user location',
        ]));

        $this->otherUser = $otherUser;
    }

    public function test_team_member_roles_can_be_updated()
    {
        $team = $this->user->teams()->first();

        $team->users()->attach(
            $this->otherUser, ['role_id' => Role::findOrCreate('admin')->id]
        );

        Livewire::test(ManageTeamMembers::class, ['team' => $team])
                        ->set('managingRoleFor', $this->otherUser)
                        ->set('currentRole', Role::findOrCreate('member')->id)
                        ->call('updateUserRole');

        
        $this->assertTrue($this->otherUser->fresh()->hasTeamRole(
            $team->fresh(), 'member'
        ));
    }

    public function test_only_team_owner_can_update_team_member_roles()
    {
        $team = $this->user->teams()->first();

        $team->users()->attach(
            $this->otherUser, ['role_id' => Role::findOrCreate('admin')->id]
        );

        $this->actingAs($this->otherUser);

        Livewire::test(ManageTeamMembers::class, ['team' => $team])
                        ->set('managingRoleFor', $this->otherUser)
                        ->set('currentRole', Role::findOrCreate('member')->id)
                        ->call('updateUserRole');

        $this->assertTrue($this->otherUser->fresh()->hasTeamRole(
            $team->fresh(), 'admin'
        ));
    }
}
