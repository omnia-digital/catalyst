@extends('social::livewire.layouts.main-layout')


@section('content')
<div class="mx-auto max-w-4xl">
    <x-teams.partials.header :team="$team" />
    <div class="mt-4 -ml-4">
        <h2 class="text-black font-semibold text-2xl">Members</h2>
    
        <div x-data="setup()">
            <!-- Project Members Navigation -->
            <div class="w-full mt-6">
                <nav class="flex items-center justify-between text-xs">
                    <ul class="flex font-semibold border-b-2 border-gray-300 w-full pb-3 space-x-10">
                        <template x-for="(tab, index) in tabs" :key="tab.id">
                            <li class="pb-px">
                                <a href="#" 
                                    class="text-gray-400 transition duration-150 ease-in border-b-2 border-transparent pb-3 hover:border-dark-text-color focus:border-dark-text-color"
                                    :class="(activeTab === tab.id) && 'border-dark-text-color text-dark-text-color'"
                                    x-on:click.prevent="activeTab = tab.id;"
                                    x-text="tab.title"
                                ></a>
                            </li>
                        </template>
                    </ul>
            
                </nav>
            </div>
    
            <!-- Member Overview -->
            <div x-show="activeTab === 0" class="mt-6 space-y-6">
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <img class="w-8 h-8 rounded-full" src="{{ $team->owner->profile_photo_url }}" alt="{{ $team->owner->name }}">
                            <div class="ml-4">{{ $team->owner->name }}</div>
                        </div>

                        <div class="flex items-center">
                            <div class="ml-2 text-sm text-light-text-color">
                                Owner
                            </div>
                        </div>
                    </div>
                    @foreach ($team->users->sortBy('name') as $user)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <img class="w-8 h-8 rounded-full" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                                <div class="ml-4">{{ $user->name }}</div>
                            </div>

                            <div class="flex items-center">
                                <!-- Manage Team Member Role -->
                                @if (Gate::check('addTeamMember', $team) && Laravel\Jetstream\Jetstream::hasRoles())
                                    <button class="ml-2 text-sm text-light-text-color underline hover:no-underline active:no-underline" wire:click="manageRole('{{ $user->id }}')">
                                        {{ $user->membership->role ? Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name : 'No Role' }}
                                    </button>
                                @elseif (Laravel\Jetstream\Jetstream::hasRoles())
                                    <div class="ml-2 text-sm text-light-text-color">
                                        {{ $user->membership->role ? Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name : '' }}
                                    </div>
                                @endif

                                <!-- Leave Team -->
                                @if ($this->user->id === $user->id)
                                    <button class="cursor-pointer ml-6 text-sm text-red-500" wire:click="$toggle('confirmingLeavingTeam')">
                                        {{ __('Leave') }}
                                    </button>

                                <!-- Remove Team Member -->
                                @elseif (Gate::check('removeTeamMember', $team))
                                    <button class="cursor-pointer ml-6 text-sm text-red-500" wire:click="confirmTeamMemberRemoval('{{ $user->id }}')">
                                        {{ __('Remove') }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mt-4">
                    @foreach ($team->members() as $member)
                        <x-user-tile :user="$member" :team="$team" />
                    @endforeach
                </div> --}}
            </div>
    
            <!-- Team Invitations -->
            <div x-cloak x-show="activeTab === 1" class="mt-6 space-y-6">
                <div>
                    @if (Gate::check('addTeamMember', $team))
                        <x-jet-section-border />
                
                        <!-- Add Team Member -->
                        <div class="mt-10 sm:mt-0">
                            <x-jet-form-section submit="addTeamMember">
                                <x-slot name="title">
                                    {{ __('Add Team Member') }}
                                </x-slot>
                
                                <x-slot name="description">
                                    {{ __('Add a new team member to your team, allowing them to collaborate with you.') }}
                                </x-slot>
                
                                <x-slot name="form">
                                    <div class="col-span-6">
                                        <div class="max-w-xl text-sm text-base-text-color">
                                            {{ __('Please provide the email address of the person you would like to add to this team.') }}
                                        </div>
                                    </div>
                
                                    <!-- Member Email -->
                                    <div class="col-span-6 sm:col-span-4">
                                        <x-jet-label for="email" value="{{ __('Email') }}" />
                                        <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="addTeamMemberForm.email" />
                                        <x-jet-input-error for="email" class="mt-2" />
                                    </div>
                
                                    <!-- Role -->
                                    @if (count($this->roles) > 0)
                                        <div class="col-span-6 lg:col-span-4">
                                            <x-jet-label for="role" value="{{ __('Role') }}" />
                                            <x-jet-input-error for="role" class="mt-2" />
                
                                            <div class="relative z-0 mt-1 border border-neutral-light rounded-lg cursor-pointer">
                                                @foreach ($this->roles as $index => $role)
                                                    <button type="button" class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-secondary focus:ring focus:ring-secondary-light {{ $index > 0 ? 'border-t border-neutral-light rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}"
                                                                    wire:click="$set('addTeamMemberForm.role', '{{ $role->key }}')">
                                                        <div class="{{ isset($addTeamMemberForm['role']) && $addTeamMemberForm['role'] !== $role->key ? 'opacity-50' : '' }}">
                                                            <!-- Role Name -->
                                                            <div class="flex items-center">
                                                                <div class="text-sm text-base-text-color {{ $addTeamMemberForm['role'] == $role->key ? 'font-semibold' : '' }}">
                                                                    {{ $role->name }}
                                                                </div>
                
                                                                @if ($addTeamMemberForm['role'] == $role->key)
                                                                    <svg class="ml-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                                @endif
                                                            </div>
                
                                                            <!-- Role Description -->
                                                            <div class="mt-2 text-xs text-base-text-color text-left">
                                                                {{ $role->description }}
                                                            </div>
                                                        </div>
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                
                                    <!-- Invitation Message -->
                                    <div class="col-span-6 sm:col-span-4">
                                        <x-jet-label for="message" value="{{ __('Message') }}" />
                                        <x-jet-input id="message" type="text" class="mt-1 block w-full" wire:model.defer="addTeamMemberForm.message" />
                                        <x-jet-input-error for="message" class="mt-2" />
                                    </div>
                                </x-slot>
                
                                <x-slot name="actions">
                                    <x-jet-action-message class="mr-3" on="saved">
                                        {{ __('Added.') }}
                                    </x-jet-action-message>
                
                                    <x-jet-button>
                                        {{ __('Add') }}
                                    </x-jet-button>
                                </x-slot>
                            </x-jet-form-section>
                        </div>
                    @endif
                
                    @if ($team->teamInvitations->isNotEmpty() && Gate::check('addTeamMember', $team))
                        <x-jet-section-border />
                
                        <!-- Team Member Invitations -->
                        <div class="mt-10 sm:mt-0">
                            <x-jet-action-section>
                                <x-slot name="title">
                                    {{ __('Pending Team Invitations') }}
                                </x-slot>
                
                                <x-slot name="description">
                                    {{ __('These people have been invited to your team and have been sent an invitation email. They may join the team by accepting the email invitation.') }}
                                </x-slot>
                
                                <x-slot name="content">
                                    <div class="space-y-6">
                                        @foreach ($team->teamInvitations as $invitation)
                                            <div class="flex items-center justify-between">
                                                <div class="text-base-text-color">{{ $invitation->email }}</div>
                
                                                <div class="flex items-center">
                                                    @if (Gate::check('removeTeamMember', $team))
                                                        <!-- Cancel Team Invitation -->
                                                        <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none"
                                                                            wire:click="cancelTeamInvitation({{ $invitation->id }})">
                                                            {{ __('Cancel') }}
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </x-slot>
                            </x-jet-action-section>
                        </div>
                    @endif
                </div>
            </div>
    
            <!-- Team Applications -->
            <div x-cloak x-show="activeTab === 2" class="mt-6 space-y-6">
                <x-jet-section-border />
    
                <!-- Team Member Applications -->
                <div class="mt-10 sm:mt-0">
                    <x-jet-action-section>
                        <x-slot name="title">
                            {{ __('Pending Team Applications') }}
                        </x-slot>
    
                        <x-slot name="description">
                            {{ __('These people have applied to your team. They may join the team after you accept their application.') }}
                        </x-slot>
    
                        <x-slot name="content">
                            <div class="space-y-6">
                                @forelse ($team->teamApplications as $application)
                                    <div class="flex items-center justify-between">
                                        <div class="text-base-text-color">{{ $application->user->name }} ({{ $application->user->email }})</div>
    
                                        <div class="flex items-center">
                                            <button type="button" 
                                                class="inline-flex items-center px-4 py-2 rounded-full bg-primary text-black text-sm tracking-wide font-medium border border-black hover:bg-neutral-light" 
                                                wire:click.prevent="addTeamMemberUsingID({{ $application->user->id }})"
                                            >Accept</button>
                                            @if (Gate::check('removeTeamMember', $team))
                                                <!-- Deny Team Application -->
                                                <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none"
                                                    wire:click="denyTeamApplication({{ $application->id }})">
                                                    {{ __('Deny') }}
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div>
                                        <p>No current applications</p>
                                    </div>
                                @endforelse
                            </div>
                        </x-slot>
                    </x-jet-action-section>
                </div>
            </div>
    
        </div>
        @once
            <!-- Role Management Modal -->
            <x-jet-dialog-modal wire:model="currentlyManagingRole">
                <x-slot name="title">
                    {{ __('Manage Role') }}
                </x-slot>
        
                <x-slot name="content">
                    <div class="relative z-0 mt-1 border border-neutral-light rounded-lg cursor-pointer">
                        @foreach ($this->roles as $index => $role)
                            <button type="button" class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-secondary focus:ring focus:ring-secondary-light {{ $index > 0 ? 'border-t border-neutral-light rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}"
                                            wire:click="$set('currentRole', '{{ $role->key }}')">
                                <div class="{{ $currentRole !== $role->key ? 'opacity-50' : '' }}">
                                    <!-- Role Name -->
                                    <div class="flex items-center">
                                        <div class="text-sm text-base-text-color {{ $currentRole == $role->key ? 'font-semibold' : '' }}">
                                            {{ $role->name }}
                                        </div>
        
                                        @if ($currentRole == $role->key)
                                            <svg class="ml-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        @endif
                                    </div>
        
                                    <!-- Role Description -->
                                    <div class="mt-2 text-xs text-base-text-color">
                                        {{ $role->description }}
                                    </div>
                                </div>
                            </button>
                        @endforeach
                    </div>
                </x-slot>
        
                <x-slot name="footer">
                    <x-jet-secondary-button wire:click="stopManagingRole" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-jet-secondary-button>
        
                    <x-jet-button class="ml-2" wire:click="updateRole" wire:loading.attr="disabled">
                        {{ __('Save') }}
                    </x-jet-button>
                </x-slot>
            </x-jet-dialog-modal>
        
            <!-- Leave Team Confirmation Modal -->
            <x-jet-confirmation-modal wire:model="confirmingLeavingTeam">
                <x-slot name="title">
                    {{ __('Leave Team') }}
                </x-slot>
        
                <x-slot name="content">
                    {{ __('Are you sure you would like to leave this team?') }}
                </x-slot>
        
                <x-slot name="footer">
                    <x-jet-secondary-button wire:click="$toggle('confirmingLeavingTeam')" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-jet-secondary-button>
        
                    <x-jet-danger-button class="ml-2" wire:click="leaveTeam" wire:loading.attr="disabled">
                        {{ __('Leave') }}
                    </x-jet-danger-button>
                </x-slot>
            </x-jet-confirmation-modal>

            <!-- Remove Team Member Confirmation Modal -->
            <x-jet-confirmation-modal wire:model="confirmingTeamMemberRemoval">
                <x-slot name="title">
                    {{ __('Remove Team Member') }}
                </x-slot>
        
                <x-slot name="content">
                    {{ __('Are you sure you would like to remove this person from the team?') }}
                </x-slot>
        
                <x-slot name="footer">
                    <x-jet-secondary-button wire:click="$toggle('confirmingTeamMemberRemoval')" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-jet-secondary-button>
        
                    <x-jet-danger-button class="ml-2" wire:click="removeTeamMember" wire:loading.attr="disabled">
                        {{ __('Remove') }}
                    </x-jet-danger-button>
                </x-slot>
            </x-jet-confirmation-modal>
        @endonce
    </div>
</div>
@endsection
@push('scripts')
    <script>
        function setup() {
            return {
                activeTab: 0,
                tabs: [
                    {
                        id: 0,
                        title: 'All',
                        /* component: 'social::pages.projects.partials.edit-project-basic' */
                    },
                    {
                        id: 1,
                        title: 'Invitations',
                        /* component: 'teams.team-member-manager' */
                    },
                    {
                        id: 2,
                        title: 'Applications',
                        /* component: */
                    }
                ]
            }
        }
    </script>
@endpush
