<div>
    <div>
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Roles</h3>
                    <p class="mt-1 text-sm text-gray-600">This is where you can manage the roles for your {{ \Trans::get('team') }} members</p>
                </div>
            </div>
            <div class="mt-5 md:col-span-2 md:mt-0">
                <form action="#" method="POST">
                    <div class="shadow sm:overflow-hidden sm:rounded-md">
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
                                        </div>

                                        <!-- Actions -->
                                        <div class="mt-4 flex justify-end space-x-2">
                                            <button 
                                                wire:click="editTeamRole('{{ $role->id }}')"
                                                type="button" 
                                                class="border border-gray-300 p-1.5 rounded-lg hover:bg-gray-200">
                                                <x-heroicon-o-pencil class="w-3.5 h-3.5" />
                                                <span class="sr-only">Edit Role</span>
                                            </button>
                                            <button 
                                                wire:click="confirmDeleteTeamRole('{{ $role->id }}')"
                                                type="button" 
                                                class="border border-gray-300 p-1 rounded-lg hover:bg-gray-200">
                                                <x-heroicon-o-trash class="w-3.5 h-3.5" />
                                                <span class="sr-only">Delete Role</span>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                            <x-library::button wire:click="createNewRole">Create New Role</x-library::button>
                        </div>
                    </div>
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
                        <x-library::input.label value="Role type"/>
                        <x-library::input.select id="role-type" wire:model.defer="editingRole.type" :options="$this->roleTypeOptions()" placeholder="Select Role type" />
                        <x-library::input.error for="editingRole.type"/>
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
    @endonce
</div>
