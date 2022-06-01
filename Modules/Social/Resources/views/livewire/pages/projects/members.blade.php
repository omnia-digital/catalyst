@extends('social::livewire.layouts.main-layout')


@section('content')
<div class="-mx-4">
    <div class="h-60 bg-[url('https://source.unsplash.com/random')] bg-cover bg-no-repeat relative overlay before:bg-black"></div>
    <x-teams.overview-navigation class="bg-gray-300" :team="$team" pageView="members" />
</div>
<div class="mt-4 -mx-4">
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mt-4">
                @foreach ($team->members() as $member)
                    <livewire:social::user-tile :user="$member" :key="'member-' . $member->id" />
                @endforeach
            </div>
        </div>

        <!-- Team Invitations -->
        <div x-cloak x-show="activeTab === 1" class="mt-6 space-y-6">
            @livewire('teams.team-member-manager', ['team' => $team])
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
                                            wire:click.prevent="addTeamMember({{ $application->user->id }})"
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
