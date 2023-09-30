@php use Spatie\Permission\Models\Role; @endphp
<div class="mt-4 mx-6">
    <x-library::heading.2
            class="text-base-text-color font-semibold text-2xl">{{ Trans::get('Members') }}</x-library::heading.2>

    <div x-data="{
        activeMembersTab: 1,
        membersTabs: [
            {
                id: 0,
                title: 'All Members',
                /* component: 'social::pages.teams.partials.edit-team-basic' */
            },
            {
                id: 1,
                title: 'Invitations',
                count: $wire.invitationsCount
                /* component: 'teams.team-member-manager' */
            },
            {
                id: 2,
                title: 'Applications',
                count: $wire.applicationsCount
                /* component: */
            },
            {
                id: 3,
                title: 'Roles & Permissions',
            },
        ]
    }">
        <!-- Team Members Navigation -->
        <div class="mt-6">
            <div class="border-b border-gray-400">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <template x-for="(tab, index) in membersTabs" :key="tab.id" hidden>
                        <a href="#"
                           class="text-gray-400 transition duration-150 ease-in border-transparent hover:text-gray-700 hover:border-gray-200 whitespace-nowrap flex py-4 px-1 border-b-2 font-medium text-sm hover:border-dark-text-color focus:border-dark-text-color"
                           :class="(activeMembersTab === tab.id) && 'border-dark-text-color text-dark-text-color'"
                           x-on:click.prevent="activeMembersTab = tab.id;"
                        >
                            <span x-text="tab.title"></span>
                            <span
                                    x-show="tab.count"
                                    x-text="tab.count"
                                    class=" ml-3 py-0.5 px-2.5 rounded-full text-xs font-bold text-white md:inline-block bg-primary"
                            ></span>
                        </a>
                    </template>
                </nav>
            </div>
        </div>

        <!-- Member Overview -->
        <div x-show="activeMembersTab === 0" class="mt-6 px-6 space-y-6">
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img class="w-8 h-8 rounded-full" src="{{ $team->owner->profile_photo_url }}"
                             alt="{{ $team->owner->name }}">
                        <div class="ml-4"><a href="{{ $team->owner->url() }}"
                                             class="hover:underline focus:underline">{{ $team->owner->name }}</a></div>
                    </div>

                    <div class="flex items-center">
                        <div class="ml-2 text-sm text-light-text-color">
                            Owner
                        </div>
                    </div>
                </div>
                @foreach ($team->members->sortBy('name') as $member)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <img class="w-8 h-8 rounded-full" src="{{ $member->profile_photo_url }}"
                                 alt="{{ $member->name }}">
                            <div class="ml-4"><a href="{{ $member->url() }}"
                                                 class="hover:underline focus:underline">{{ $member->name }}</a></div>
                        </div>

                        <div class="flex items-center">
                            <!-- Manage Team Member Role -->
                            @if (Gate::check('addTeamMember', $team) && Laravel\Jetstream\Jetstream::hasRoles())
                                <button class="ml-2 text-sm text-light-text-color underline hover:no-underline active:no-underline"
                                        wire:click="manageRole('{{ $member->id }}')">
                                    {{ Role::find($member->membership->role_id)->name ?? 'No Role' }}
                                </button>
                            @elseif (Laravel\Jetstream\Jetstream::hasRoles())
                                <div class="ml-2 text-sm text-light-text-color">
                                    {{ Role::find($member->membership->role_id)->name ?? '' }}
                                </div>
                            @endif

                            <!-- Leave Team -->
                            @if ($this->user->id === $member->id)
                                <button class="cursor-pointer ml-6 text-sm text-red-500 hover:underline focus:underline"
                                        wire:click="$toggle('confirmingLeavingTeam')">
                                    {{ Trans::get('Leave') }}
                                </button>

                                <!-- Remove Team Member -->
                            @elseif (Gate::check('removeTeamMember', $team))
                                <button
                                        wire:click="confirmTeamMemberRemoval('{{ $member->id }}')"
                                        class="cursor-pointer ml-6 text-sm text-red-500 hover:underline focus:underline"
                                >{{ Trans::get('Remove') }}</button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Team Invitations -->
        <div x-cloak x-show="activeMembersTab === 1" class="mt-6 px-6 space-y-6">
            <div>
                @if (Gate::check('addTeamMember', $team))
                    <x-section-border/>

                    <!-- Add Team Member -->
                    <div class="mt-10 sm:mt-0">
                        <x-form-section submit="addTeamMember">
                            <x-slot name="title">
                                {{ Trans::get('Add Team Member') }}
                            </x-slot>

                            <x-slot name="description">
                                {{ Trans::get('Add a new team member to your team, allowing them to collaborate with you.') }}
                            </x-slot>

                            <x-slot name="form">
                                <div class="col-span-6">
                                    <div class="max-w-xl text-sm text-base-text-color">
                                        {{ Trans::get('Please provide the email address of the person you would like to add to this team.') }}
                                    </div>
                                </div>

                                <!-- Member Email -->
                                <div class="col-span-6 sm:col-span-4">
                                    <x-label for="email" value="{{ Trans::get('Email') }}"/>
                                    <x-input id="email" type="email" class="mt-1 block w-full"
                                             wire:model="addTeamMemberForm.email"/>
                                    <x-input-error for="email" class="mt-2"/>
                                </div>

                                <!-- Role -->
                                @if (count($this->roles) > 0)
                                    <div class="col-span-6 lg:col-span-4">
                                        <x-label for="role" value="{{ Trans::get('Role') }}"/>
                                        <x-input-error for="role" class="mt-2"/>

                                        <div class="relative z-0 mt-1 border border-neutral-light rounded-lg cursor-pointer">
                                            @foreach ($this->roles as $index => $role)
                                                <button type="button"
                                                        class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-primary focus:ring focus:ring-primary-light {{ $index > 0 ? 'border-t border-neutral-light rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}"
                                                        wire:click="$set('addTeamMemberForm.role', '{{ $role->name }}')">
                                                    <div class="{{ isset($addTeamMemberForm['role']) && $addTeamMemberForm['role'] !== $role->name ? 'opacity-50' : '' }}">
                                                        <!-- Role Name -->
                                                        <div class="flex items-center">
                                                            <div class="text-sm text-base-text-color {{ $addTeamMemberForm['role'] == $role->name ? 'font-semibold' : '' }}">
                                                                {{ $role->name }}
                                                            </div>

                                                            @if ($addTeamMemberForm['role'] == $role->name)
                                                                <svg class="ml-2 h-5 w-5 text-green-400" fill="none"
                                                                     stroke-linecap="round" stroke-linejoin="round"
                                                                     stroke-width="2"
                                                                     stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                </svg>
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
                                    <x-label for="message" value="{{ Trans::get('Message') }}"/>
                                    <x-input id="message" type="text" class="mt-1 block w-full"
                                             wire:model="addTeamMemberForm.message"/>
                                    <x-input-error for="message" class="mt-2"/>
                                </div>
                            </x-slot>

                            <x-slot name="actions">
                                <x-action-message class="mr-3" on="saved">
                                    {{ Trans::get('Added.') }}
                                </x-action-message>

                                <x-button>
                                    {{ Trans::get('Add') }}
                                </x-button>
                            </x-slot>
                        </x-form-section>
                    </div>
                @endif

                @if ($team->teamInvitations->isNotEmpty() && Gate::check('addTeamMember', $team))
                    <x-section-border/>

                    <!-- Team Member Invitations -->
                    <div class="mt-10 sm:mt-0">
                        <x-action-section>
                            <x-slot name="title">
                                {{ Trans::get('Pending Team Invitations') }}
                            </x-slot>

                            <x-slot name="description">
                                {{ Trans::get('These people have been invited to your team and have been sent an invitation email. They may join the team by accepting the email invitation.') }}
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
                                                        {{ Trans::get('Cancel') }}
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </x-slot>
                        </x-action-section>
                    </div>
                @endif
            </div>
        </div>

        <!-- Team Applications -->
        <div x-cloak x-show="activeMembersTab === 2" class="mt-6 px-6 space-y-6">
            <x-section-border/>

            <!-- Team Member Applications -->
            <div class="mt-10 sm:mt-0">
                <x-action-section>
                    <x-slot name="title">
                        {{ Trans::get('Pending Team Applications') }}
                    </x-slot>

                    <x-slot name="description">
                        {{ Trans::get('These people have applied to your team and may join after you accept their application.') }}
                    </x-slot>

                    <x-slot name="content">
                        <div class="space-y-6">
                            @forelse ($team->teamApplications as $application)
                                <div class="flex items-center justify-between">
                                    <div class="text-base-text-color">{{ $application->user->name }}
                                        ({{ $application->user->email }})
                                    </div>

                                    <div class="flex items-center">
                                        @if (Gate::check('addTeamMember', $team))
                                            <button type="button"
                                                    class="inline-flex items-center px-4 py-2 rounded-full bg-secondary text-base-text-color text-sm tracking-wide font-medium border border-black hover:bg-neutral-light"
                                                    wire:click.prevent="addTeamMemberUsingID({{ $application->user->id }})"
                                            >Accept
                                            </button>
                                        @endif
                                        @if (Gate::check('removeTeamMember', $team))
                                            <!-- Deny Team Application -->
                                            <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none"
                                                    wire:click="denyTeamApplication({{ $application->id }})">
                                                {{ Trans::get('Deny') }}
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
                </x-action-section>
            </div>
        </div>

        <!-- Team Roles -->
        <div x-cloak x-show="activeMembersTab === 3" class="mt-6 px-6 space-y-6">
            <div>
                <livewire:social::pages.teams.admin.manage-team-roles :team="$team"/>
            </div>
        </div>
    </div>
    @once
        <!-- Role Management Modal -->
        <x-dialog-modal wire:model.live="currentlyManagingRole">
            <x-slot name="title">
                {{ Trans::get('Manage User Role') }}
            </x-slot>

            <x-slot name="content">
                <div class="relative z-0 mt-1 border border-neutral-light rounded-lg cursor-pointer">
                    @foreach ($this->roles as $index => $role)
                        <button type="button"
                                class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-primary focus:ring focus:ring-primary-light {{ $index > 0 ? 'border-t border-neutral-light rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}"
                                wire:click="$set('currentRole', '{{ $role->id }}')">
                            <div class="{{ $currentRole != $role->id ? 'opacity-50' : '' }}">
                                <!-- Role Name -->
                                <div class="flex items-center">
                                    <div class="text-sm text-base-text-color {{ $currentRole == $role->id ? 'font-semibold' : '' }}">
                                        {{ $role->name }}
                                    </div>

                                    @if ($currentRole == $role->id)
                                        <svg class="ml-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round"
                                             stroke-linejoin="round" stroke-width="2" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
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
                <x-secondary-button wire:click="stopManagingRole" wire:loading.attr="disabled">
                    {{ Trans::get('Cancel') }}
                </x-secondary-button>

                <x-button class="ml-2" wire:click="updateUserRole" wire:loading.attr="disabled">
                    {{ Trans::get('Save') }}
                </x-button>
            </x-slot>
        </x-dialog-modal>

        <!-- Leave Team Confirmation Modal -->
        <x-confirmation-modal wire:model.live="confirmingLeavingTeam">
            <x-slot name="title">
                {{ Trans::get('Leave Team') }}
            </x-slot>

            <x-slot name="content">
                {{ Trans::get('Are you sure you would like to leave this team?') }}
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingLeavingTeam')" wire:loading.attr="disabled">
                    {{ Trans::get('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-2" wire:click="leaveTeam" wire:loading.attr="disabled">
                    {{ Trans::get('Leave') }}
                </x-danger-button>
            </x-slot>
        </x-confirmation-modal>

        <!-- Remove Team Member Confirmation Modal -->
        <x-confirmation-modal wire:model.live="confirmingTeamMemberRemoval">
            <x-slot name="title">
                {{ Trans::get('Remove Team Member') }}
            </x-slot>

            <x-slot name="content">
                {{ Trans::get('Are you sure you would like to remove this person from the team?') }}
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingTeamMemberRemoval')" wire:loading.attr="disabled">
                    {{ Trans::get('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-2" wire:click="removeTeamMember" wire:loading.attr="disabled">
                    {{ Trans::get('Remove') }}
                </x-danger-button>
            </x-slot>
        </x-confirmation-modal>
    @endonce
</div>
