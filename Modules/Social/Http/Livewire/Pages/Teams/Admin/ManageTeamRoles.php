<?php

namespace Modules\Social\Http\Livewire\Pages\Teams\Admin;

use App\Enums\Teams\TeamRoleTypes;
use App\Models\Team;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class ManageTeamRoles extends Component
{
    public $team;
    public $confirmingDeleteTeamRole = false;
    public $currentlyEditingRole = false;
    public $roleIdBeingRemoved = null;
    public Role $editingRole;

    public function rules()
    {
        return [
            'editingRole.team_id' => 'required|integer',
            'editingRole.name' => 'required|alpha_num',
            'editingRole.type' => 'required|in:' . implode(',', TeamRoleTypes::keys()),
            'editingRole.description' => 'required|min:4|max:255'
        ];
    }

    public function mount(Team $team)
    {
        $this->team = $team;
        $this->editingRole = $this->makeBlankRole();
    }

    public function makeBlankRole()
    {
        return Role::make([
            'team_id' => $this->team->id,
            'name' => '',
            'type' => '',
            'description' => ''
        ]);
    }

    public function saveRole()
    {
        $this->validate();
        
        $this->editingRole->save();

        $this->currentlyEditingRole = false;
    }

    public function createNewRole()
    {
        if ($this->editingRole->getKey()) $this->editingRole = $this->makeBlankRole();

        $this->currentlyEditingRole = true;
    }

    public function confirmDeleteTeamRole($roleId)
    {
        $this->roleIdBeingRemoved = $roleId;

        $this->confirmingDeleteTeamRole = true;
    }

    public function deleteTeamRole()
    {
        $role = Role::find($this->roleIdBeingRemoved);
        $role->permissions()->detach();
        $role->delete();

        $this->confirmingDeleteTeamRole = false;
    }

    public function editTeamRole(Role $role)
    {
        if ($this->editingRole->isNot($role)) $this->editingRole = $role;

        $this->currentlyEditingRole = true;
    }

    public function roleTypeOptions()
    {
        return TeamRoleTypes::options();
    }

    public function getRolesProperty()
    {
        return Role::where('team_id', $this->team->id)->get();
    }

    public function render()
    {
        return view('social::livewire.pages.teams.admin.manage-team-roles');
    }
}
