<?php

namespace Modules\Social\Http\Livewire\Pages\Teams\Admin;

use App\Models\Team;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManageTeamRoles extends Component
{
    use AuthorizesRequests;

    public $team;
    public $confirmingDeleteTeamRole = false;
    public $currentlyEditingRole = false;
    public $currentlyAddingPermission = false;
    public $roleToAttachPermission = null;
    public $roleIdBeingRemoved = null;
    public Role $editingRole;
    public $selectedPermissions = [];
    public $permissionsToAttach = [];

    public function rules()
    {
        return [
            'editingRole.team_id' => 'required|integer',
            'editingRole.description' => 'required|min:4|max:255',
            'permissionsToAttach' => ['nullable', 'array'],
            'editingRole.name' => [
                'required',
                'alpha_num',
                function ($attribute, $value, $fail) {
                    if (strtolower($value) === strtolower(config('platform.teams.default_owner_role'))) {
                        $fail('You cannot create another role called ' . config('platform.teams.default_owner_role') . '.');
                    }
                },
            ],
            'editingRole.description' => 'required|min:4|max:255',
            'permissionsToAttach' => ['nullable', 'array'],
        ];
    }

    public function mount(Team $team)
    {
        $this->team = $team;
        $this->editingRole = $this->makeBlankRole();
        $this->resetSelectedPermissions();
    }

    public function makeBlankRole()
    {
        return Role::make([
            'team_id' => $this->team->id,
            'name' => '',
            'type' => '',
            'description' => '',
        ]);
    }

    public function resetSelectedPermissions()
    {
        foreach ($this->roles as $role) {
            $this->selectedPermissions[$role->id] = [];
        }
    }

    public function saveRole()
    {
        $this->validate();

        $this->editingRole->save();

        $this->currentlyEditingRole = false;

        $this->selectedPermissions[$this->editingRole->id] = [];
    }

    public function createNewRole()
    {
        $this->authorize('createTeamRole', $this->team);

        if ($this->editingRole->getKey()) {
            $this->editingRole = $this->makeBlankRole();
        }

        $this->currentlyEditingRole = true;
    }

    public function confirmDeleteTeamRole($roleId)
    {
        $this->authorize('deleteTeamRole', $this->team);

        $this->roleIdBeingRemoved = $roleId;

        $this->confirmingDeleteTeamRole = true;
    }

    public function deleteTeamRole()
    {
        $this->authorize('deleteTeamRole', $this->team);

        $role = Role::find($this->roleIdBeingRemoved);
        $role->permissions()->detach();
        $role->delete();

        $this->confirmingDeleteTeamRole = false;

        unset($this->selectedPermissions[$this->roleIdBeingRemoved]);
    }

    public function editTeamRole(Role $role)
    {
        $this->authorize('updateTeamRole', $this->team);

        if ($this->editingRole->isNot($role)) {
            $this->editingRole = $role;
        }

        $this->currentlyEditingRole = true;
    }

    public function addPermissions($roleId)
    {
        $this->authorize('updateTeamRole', $this->team);

        $this->roleToAttachPermission = Role::find($roleId);

        $this->permissionsToAttach = [];

        $this->currentlyAddingPermission = true;
    }

    public function attachPermissions()
    {
        $this->authorize('updateTeamRole', $this->team);

        $this->roleToAttachPermission->permissions()->attach($this->permissionsToAttach);

        $this->closePermissionsModal();
    }

    public function closePermissionsModal()
    {
        $this->currentlyAddingPermission = false;

        $this->permissionsToAttach = [];

        $this->roleToAttachPermission = null;
    }

    public function detachPermissions($roleId)
    {
        $this->authorize('updateTeamRole', $this->team);

        Role::find($roleId)->permissions()->detach($this->selectedPermissions[$roleId]);

        $this->selectedPermissions[$roleId] = [];
    }

    public function getRolesProperty()
    {
        return Role::where('team_id', $this->team->id)->with('permissions')->get();
    }

    public function getPermissionsProperty()
    {
        return Permission::get();
    }

    public function getAvailablePermissionsProperty()
    {
        $rolePermissionIds = $this->roleToAttachPermission?->permissions()->pluck('id')->toArray() ?? [];

        return Permission::whereNotIn('id', $rolePermissionIds)->pluck('name', 'id');
    }

    public function render()
    {
        return view('social::livewire.pages.teams.admin.manage-team-roles');
    }
}
