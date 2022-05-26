@extends('social::livewire.layouts.main-layout')

@section('full-width-header')
    <div class="col-span-2 h-36 bg-[url('https://source.unsplash.com/random')] -mx-4 bg-cover bg-no-repeat"></div>
@endsection

@section('content')
<div>
    <!-- Page Heading -->
    <div class="space-y-8">
        <nav>
            <ol class="list-reset flex items-center">
              <li><a href="{{ route('social.my-projects') }}" class="font-bold hover:underline">My Projects</a></li>
              <li><x-heroicon-s-chevron-right class="h-4 w-4 mx-2" /></li>
              <li><a href="{{ $team->profile() }}" class="font-bold hover:underline">{{ $team->name }}</a></li>
            </ol>
        </nav>
        <div class="border-b-2 border-b-light-text-color pb-1">
            <h1 class="text-3xl"><span class="text-dark-text-color">Project Admin Page: </span><span class="text-light-text-color">{{ $team->name }}</span></h1>
        </div>
    </div>

    <div class="mt-6 flex justify-end items-center">
        <div class="mr-auto" 
            x-data="{show: false}" 
            x-show="show"
            x-transition:leave.opacity.duration.1500ms 
            x-init="@this.on('changes_saved', () => { 
                show = true; 
                setTimeout(() => { show = false; }, 3000);
            })"
            style="display: none;"
        >
            <p class="text-sm opa text-green-600">Project saved.</p>
        </div>
        <div class="mr-4"><a href="{{ $team->profile() }}" class="hover:underline">Cancel</a></div>
        <x-library::button.index 
            wire:click.prevent="saveChanges"
        >Save Changes</x-library::button.index>
    </div>

    <div x-data="setup()">
        <!-- Project Edit Navigation -->
        <div class="w-full mt-6"
            <nav class="flex items-center justify-between text-xs">
                <ul class="flex font-semibold border-b-2 border-gray-300 w-full pb-3 space-x-10">
                    <template x-for="(tab, index) in tabs" :key="tab.id">
                        <li class="pb-px">
                            <a href="#" 
                                class="text-gray-400 transition duration-150 ease-in border-b-2 border-transparent pb-4 hover:border-dark-text-color focus:border-dark-text-color"
                                :class="(activeTab === tab.id) && 'border-dark-text-color text-dark-text-color'"
                                x-on:click.prevent="activeTab = tab.id;"
                                x-text="tab.title"
                            ></a>
                        </li>
                    </template>
                </ul>
        
            </nav>
        </div>
        
        <!-- Edit Basic Team Info -->
        <div x-show="activeTab === 0" class="mt-6 space-y-6">
            <div>
                <x-library::input.label value="Name" class="inline"/><span class="text-red-600 text-sm">*</span>
                <x-library::input.text id="name" wire:model.defer="team.name" required/>
                <x-library::input.error for="name"/>
            </div>
            <div>
                <x-library::input.label value="Start Date"/>
                <x-library::input.date id="startDate" wire:model.defer="team.start_date" placeholder="Pick a date"/>
                <x-library::input.error for="startDate"/>
            </div>
            <div>
                <x-library::input.label value="Summary"/>
                <x-library::input.textarea id="summary" wire:model.defer="team.summary"/>
                <x-library::input.error for="summary"/>
            </div>
            <div>
                <x-library::input.label value="Who is this Project relevant to?"/>
                <x-library::input.text id="targetAudience" wire:model.defer="team.target_audience"/>
                <x-library::input.error for="targetAudience"/>
            </div>
            <div>
                <x-library::input.label value="About this Project"/>
                <x-library::input.textarea id="content" wire:model.defer="team.content" :rows="8"/>
                <x-library::input.error for="content"/>
            </div>
            @livewire('teams.delete-team-form', ['team' => $team])
        </div>

        <!-- Edit Team Location -->                
        <div x-show="activeTab === 1" class="mt-6 space-y-6">
            <div>
                <h3 class="text-lg">Current Project Location</h3>
                    @if ($team->teamLocation()->exists())
                        <div class="flex items-center space-x-4 py-4">
                            <p class="{{ $removeAddress ? 'line-through' : '' }}">{{ $team->location }}</p>
                            @if ($removeAddress)
                                <div class="py-2">
                                    <a href="#" 
                                        class="hover:underline" 
                                        wire:click.prevent="$set('removeAddress', false)"
                                    >Undo</a>
                                </div>
                            @else
                                <x-library::button.destruction 
                                    wire:click.prevent="$set('removeAddress', true)"
                                    class="p-1"
                                >Remove</x-library::button.destruction>
                            @endif
                        </div>
                    @else
                        <div>
                            <p>No Location has been selected for this project.</p>
                        </div>
                    @endif
                </div>
            <div>
                <h3 class="text-lg">Update Location</h3>
                <x-library::input.label value="Where will this event take place?"/>
                <div class="flex items-center space-x-2">
                    <div class="flex-1">
                        <x-library::input.place />
                    </div>
                    <x-library::button.secondary 
                        wire:click.prevent="setAddress"
                    >Set Address</x-library::button.secondary>
                </div>
            </div>
            @if (!empty($newAddress))
                <div>
                    <h3 class="text-lg">New Project Location</h3>
                    <p>{{ $this->selectedAddress }}</p>
                    <p class="text-xxs text-red-600">Please save changes to use this address</p>
                </div>
            @endif
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
                        title: 'Basic Info',
                        /* component: 'social::pages.projects.partials.edit-project-basic' */
                    },
                    {
                        id: 1,
                        title: 'Locations',
                        /* component: 'social::pages.projects.partials.edit-project-locations' */
                    },
                    {
                        id: 2,
                        title: 'Invitations',
                        /* component: 'teams.team-member-manager' */
                    },
                    {
                        id: 3,
                        title: 'Applications',
                        /* component: */
                    }
                ]
            }
        }
    </script>
@endpush
