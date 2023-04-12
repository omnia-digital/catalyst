<div class="space-y-8">
    <div>
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Roles</h3>
                    <p class="mt-1 text-sm text-gray-600">This is where you can manage the roles for your {{ \Trans::get('team') }} members</p>
                </div>
            </div>
            <div class="mt-5 md:col-span-2 md:mt-0">
                <form wire:submit.prevent="createNewRole" class="shadow sm:overflow-hidden sm:rounded-md">
                    <!-- Roles -->
                    <div class="bg-white px-4 sm:px-6 col-span-6 lg:col-span-4">

                            <div class="relative divide-y-2 border-gray-500">
                                @foreach ($this->roles as $index => $role)
                                    <div class="relative w-full py-4">
                                        <div class="">
                                            <!-- Role Name -->
                                            <div class="flex items-center">
                                                <div class="text-sm text-base-text-color">
                                                    {{ $role->name }}
                                                </div>
                                            </div>

                                            <!-- Role Description -->
                                            <div class="mt-2 text-xs text-base-text-color text-left">
                                                {{ $role->description }}
                                            </div>
                                            <div x-id="['role-permissions']" x-data="{ expanded: false }" class="mt-4 space-y-2 text-base-text-color">
                                                <div class="flex justify-between items-center">
                                                    @if ($role->permissions->count())
                                                        <button
                                                                type="button"
                                                                class="text-sm flex items-center space-x-1"
                                                                x-on:click="expanded = !expanded"
                                                        >
                                                            <span>Permissions</span>
                                                            <x-heroicon-o-chevron-down class="w-3 h-3" x-show="!expanded" />
                                                            <x-heroicon-o-chevron-up class="w-3 h-3" x-show="expanded" />
                                                        </button>
                                                    @else
                                                        <p class="text-sm">No permissions</p>
                                                    @endif
                                                    <button
                                                            type="button"
                                                            class="text-sm flex items-center p-1"
                                                            x-tooltip="Attach new permission"
                                                            wire:click="addPermissions('{{ $role->id }}')"
                                                    >
                                                        <x-heroicon-o-plus class="w-4 h-4" />
                                                    </button>
                                                </div>
                                                @if ($role->permissions->count())
                                                    <ul class="space-y-2 pl-2 columns-[100px]" x-show="expanded" x-collapse>
                                                        @foreach ($role->permissions as $permission)
                                                            <li class="text-xs group flex items-center space-x-1" wire:key="permission-{{ $permission->id }}">
                                                                <x-library::input.checkbox wire:model="selectedPermissions.{{ $role->id }}" value="{{ $permission->id }}"/>
                                                                <span class="text-ellipsis cursor-default overflow-hidden whitespace-nowrap" x-tooltip="{{ $permission->name }}">{{ $permission->name }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="mt-4 flex justify-end space-x-2">
                                            @if (!empty($selectedPermissions[$role->id]))
                                                @can('createTeamRole', $team)
                                                    <x-library::button
                                                            x-on:click="if(confirm('Are you sure you want to remove the selected permissions?')) $wire.detachPermissions('{{ $role->id }}')"
                                                            class="text-xs !p-1.5 hover:bg-primary-300">
                                                        <span>Remove Permissions</span>
                                                    </x-library::button>
                                                @endcan
                                            @endif

                                        @can('createTeamRole', $team)
                                            <!-- Actions -->
                                                    @if (strtolower($role->name) !== strtolower(config('platform.teams.default_owner_role')))

                                            <div class="mt-4 flex justify-end space-x-2">
                                                <button
                                                    wire:click="editTeamRole('{{ $role->id }}')"
                                                    type="button"
                                                    x-tooltip="Edit Role"
                                                    class="border border-gray-300 p-1.5 rounded-lg hover:bg-gray-200">
                                                    <x-heroicon-o-pencil class="w-3.5 h-3.5" />
                                                    <span class="sr-only">Edit Role</span>
                                                </button>
                                                <button
                                                    wire:click="confirmDeleteTeamRole('{{ $role->id }}')"
                                                    type="button"
                                                    x-tooltip="Delete Role"
                                                    class="border border-gray-300 p-1 rounded-lg hover:bg-gray-200">
                                                    <x-heroicon-o-trash class="w-3.5 h-3.5" />
                                                    <span class="sr-only">Delete Role</span>
                                                </button>
                                            </div>
                                                        @endif
                                        @endcan
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @can('createTeamRole', $team)
                            <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                                <x-library::button wire:click="createNewRole" class="hover:bg-primary-300" type="submit">Create New Role</x-library::button>
                            </div>
                        @endcan</form>
            </div>

        </div>
    </div>
    <div>
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Permissions</h3>
                    <p class="mt-1 text-sm text-gray-600">This is where you can view the available permissions for your {{ \Trans::get('team') }} roles</p>
                </div>
            </div>
            <div class="mt-5 md:col-span-2 md:mt-0">
                <form wire:submit.prevent="createNewRole" class="shadow sm:overflow-hidden sm:rounded-md">
                    <!-- Permissions -->
                    <div class="bg-white p-4 sm:p-6 col-span-6 lg:col-span-4">
                        <ul class="space-y-2 columns-[100px]">
                            @foreach ($this->permissions as $permission)
                                <li class="text-xs group flex items-center space-x-1" wire:key="permission-{{ $permission->id }}">
                                    <span class="text-ellipsis cursor-default overflow-hidden whitespace-nowrap" x-tooltip="{{ $permission->name }}">{{ $permission->name }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @can('createTeamRole', $team)
                        <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                            <x-library::button class="hover:bg-primary-300" type="submit">Create New Permission</x-library::button>
                        </div>
                    @endcan
                </form>
            </div>
        </div>
    </div>
    @once
        <!-- Delete Role Confirmation Modal -->
        <x-jet-confirmation-modal wire:model="confirmingDeleteTeamRole">
            <x-slot name="title">
                {{ \Trans::get('Delete Role') }}
            </x-slot>

            <x-slot name="content">
                <p>{{ \Trans::get('Are you sure you would like to delete this role?') }}</p>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$set('confirmingDeleteTeamRole', false)" wire:loading.attr="disabled">
                    {{ \Trans::get('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="deleteTeamRole" wire:loading.attr="disabled">
                    {{ \Trans::get('Delete') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-confirmation-modal>

        <!-- Role Edit Modal -->
        <x-jet-dialog-modal wire:model="currentlyEditingRole">
            <x-slot name="title">
                {{ \Trans::get('Edit Role') }}
            </x-slot>

            <x-slot name="content">
                <div class="space-y-4">
                    <div class="flex-col">
                        <x-library::input.label value="Role name" class="inline"/>
                        <span class="text-red-600 text-sm">*</span>
                        <x-library::input.text id="role-name" wire:model.defer="editingRole.name" required/>
                        <x-library::input.error for="editingRole.name"/>
                    </div>
                    <div class="flex-col">
                        <x-library::input.label value="Role description"/>
                        <x-library::input.textarea id="role-description" wire:model.defer="editingRole.description"/>
                        <x-library::input.error for="editingRole.description"/>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$set('currentlyEditingRole', false)" wire:loading.attr="disabled">
                    {{ \Trans::get('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-2" wire:click="saveRole" wire:loading.attr="disabled">
                    {{ \Trans::get('Save') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>

        <!-- Add Permission Modal -->
        <x-jet-dialog-modal wire:model="currentlyAddingPermission">
            <x-slot name="title">
                {{ \Trans::get('Attach Permissions to "' . ucfirst($roleToAttachPermission?->name) . '"') }}
            </x-slot>

            <x-slot name="content">
                <div class="space-y-4">
                    <div wire:key="permissions" class="flex-col min-h-[300px]">
                        <x-library::input.selects
                            wire:model="permissionsToAttach"
                            :options="$this->availablePermissions"
                            placeholder="Select Permissions"
                        />
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="closePermissionsModal" wire:loading.attr="disabled">
                    {{ \Trans::get('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-2" wire:click="attachPermissions" wire:loading.attr="disabled">
                    {{ \Trans::get('Save') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>
    @endonce
</div>
