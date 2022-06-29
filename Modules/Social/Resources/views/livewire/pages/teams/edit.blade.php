@extends('social::livewire.layouts.pages.full-page-layout')

@section('full-width-header')
    <div class="col-span-2 h-36 bg-[url('https://source.unsplash.com/random')] -mx-4 bg-cover bg-no-repeat"></div>
@endsection

@section('content')
    <div class="pb-4">
        <!-- Page Heading -->
        <div class="space-y-8">
            <nav>
                <ol class="list-reset flex items-center">
                    <li><a href="{{ route('social.teams.my-teams') }}" class="font-bold hover:underline">My {{ Trans::get('teams') }}</a></li>
                    <li>
                        <x-heroicon-s-chevron-right class="h-4 w-4 mx-2"/>
                    </li>
                    <li><a href="{{ $team->profile() }}" class="font-bold hover:underline">{{ $team->name }}</a></li>
                </ol>
            </nav>
            <div class="border-b-2 border-b-light-text-color pb-1">
                <h1 class="text-3xl"><span class="text-dark-text-color"> {{ Trans::get('team') }} Admin Page: </span><span class="text-light-text-color">{{ $team->name }}</span></h1>
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
                <p class="text-sm opa text-green-600">Team saved.</p>
            </div>
            @if ($errors->any())
                <div class="mr-auto">
                    <p class="text-sm text-red-600">This form has errors:</p>
                    @foreach ($errors->all() as $error)
                        <p class="text-sm text-red-600">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <div class="mr-4"><a href="{{ $team->profile() }}" class="hover:underline">Cancel</a></div>
            <x-library::button.index
                    wire:click.prevent="saveChanges"
            >Save Changes</x-library::button.index>
        </div>

        <div x-data="setup()">
            <!-- Team Edit Navigation -->
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
                <x-library::input.error for="team.name"/>
            </div>
            <div>
                <x-library::input.label value="Start Date"/>
                <x-library::input.date id="startDate" wire:model.defer="team.start_date" placeholder="Team Launch Date"/>
                <x-library::input.error for="startDate"/>
            </div>
            <div>
                <x-library::input.label value="Summary"/>
                <x-library::input.textarea id="summary" wire:model.defer="team.summary"/>
                <x-library::input.error for="team.summary"/>
            </div>
            <div>
                <x-library::input.label value="About this Team"/>
                <x-library::input.textarea id="content" wire:model.defer="team.content" :rows="8"/>
                <x-library::input.error for="team.content"/>
            </div>
            @livewire('teams.delete-team-form', ['team' => $team])
        </div>

        <!-- Edit Team Location -->
        <div x-cloak x-show="activeTab === 1" class="mt-6 space-y-6">
            <div>
                <h3 class="text-lg">Current Team Location</h3>
                @if ($team->location()->exists())
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
                            >Remove
                            </x-library::button.destruction>
                        @endif
                    </div>
                @else
                    <div>
                        <p>No Location has been selected for this team.</p>
                    </div>
                @endif
            </div>
            <div>
                <h3 class="text-lg">Update Location</h3>
                <x-library::input.label value="Where will this event take place?"/>
                <div class="flex items-center space-x-2">
                    <div class="flex-1">
                        <x-library::input.place/>
                    </div>
                    <x-library::button.secondary
                            wire:click.prevent="setAddress"
                    >Set Address
                    </x-library::button.secondary>
                </div>
            </div>
            @if (!empty($newAddress))
                <div>
                    <h3 class="text-lg">New Team Location</h3>
                    <p>{{ $this->selectedAddress }}</p>
                    <p class="text-xxs text-red-600">Please save changes to use this address</p>
                </div>
            @endif
        </div>

        <!-- Edit Team Media -->
        <div x-cloak x-show="activeTab === 2" class="mt-6 space-y-6">
            <div class="space-y-4">
                <!-- Banner Image -->
                <div>
                    <div class="flex items-center">
                        <x-library::input.label value="Banner Image" /><span class="text-red-600 text-sm ml-1">*</span>
                    </div>
                    <div class="flex justify-between items-center relative min-w-0 w-full border-gray-300 placeholder-gray-500 bg-primary rounded focus:ring-secondary focus:border-secondary text-sm p-2">
                        <input type="text" class="flex-1 border-none" wire:model="bannerImageName" placeholder="Upload file for banner" readonly>
                        <label>
                            <input type="file" wire:model="bannerImage" hidden required />
                            <span class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-secondary hover:bg-secondary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neutral-light focus:ring-secondary">Browse</span>
                        </label>
                    </div>
                    <x-library::input.error for="bannerImage" />
                    <div class="flex mt-4 space-x-2">
                        <div>
                            <p>Current Banner:</p>
                            @if ($team->bannerImage()->count())
                                <img src="{{ $team->bannerImage()->getFullUrl() }}" alt="{{ $team->bannerImage()->name }}" title="{{ $team->bannerImage()->name }}" class="w-full h-32">
                            @else
                                <p>No image set for banner</p>
                            @endif
                        </div>
                        @if ($bannerImage)
                            <div>
                                <p>New Banner:</p>
                                <img class="w-full h-32" src="{{ $bannerImage->temporaryUrl() }}" alt="{{ $bannerImageName }} Preview">
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Main Image -->
                <hr class="my-4 border-neutral-dark">
                <div>
                    <div class="flex items-center">
                        <x-library::input.label value="Main Image" /><span class="text-red-600 text-sm">*</span>
                    </div>
                    <div class="flex justify-between items-center relative min-w-0 w-full border-gray-300 placeholder-gray-500 bg-primary rounded focus:ring-secondary focus:border-secondary text-sm p-2">
                        <input type="text" class="flex-1 border-none" wire:model="mainImageName" placeholder="Upload file for banner" readonly>
                        <label>
                            <input type="file" wire:model="mainImage" hidden required />
                            <span class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-secondary hover:bg-secondary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neutral-light focus:ring-secondary">Browse</span>
                        </label>
                    </div>
                    <x-library::input.error for="mainImage" />
                    <div class="flex mt-4 space-x-2">
                        <div>
                            <p>Current Main:</p>
                            @if ($team->mainImage()->count())
                                <img src="{{ $team->mainImage()->getFullUrl() }}" alt="{{ $team->mainImage()->name }}" title="{{ $team->mainImage()->name }}" class="w-full h-32">
                            @else
                                <p>No image set for main</p>
                            @endif
                        </div>
                        @if ($mainImage)
                            <div>
                                <p>New Main:</p>
                                <img class="w-full h-32" src="{{ $mainImage->temporaryUrl() }}" alt="{{ $mainImageName }}">
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Sample Media -->
                <hr class="my-4 border-neutral-dark">
                <div>
                    <div class="flex items-center">
                        <x-library::input.label value="Sample Media" /><span class="text-red-600 text-sm ml-1">*</span>
                    </div>
                    <div class="flex justify-between items-center relative min-w-0 w-full border-gray-300 placeholder-gray-500 bg-primary rounded focus:ring-secondary focus:border-secondary text-sm p-2">
                        <p class="flex-1 py-2 px-3 text-[1rem] text-base-text-color">Upload multiple images about your project to be displayed</p>
                        <label>
                            <input type="file" wire:model="sampleMedia" hidden multiple required />
                            <span class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-secondary hover:bg-secondary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neutral-light focus:ring-secondary">Browse</span>
                        </label>
                    </div>
                    <x-library::input.error for="sampleMedia" />
                    <div class="pb-8">
                        <div class="mt-4">
                            <p>Current Sample Media:</p>
                            <div>
                                <div class="flex flex-wrap w-full">
                                    @foreach ($team->sampleImages() as $key => $media)
                                        <div class="w-40 h-32 mr-2 mt-2 flex justify-center items-center bg-primary relative border-4 border-dashed border-neutral-dark">
                                            <img src="{{ $media->getFullUrl() }}" title="{{ $media->name }}" alt="{{ $media->name }}" class="max-w-[152px] max-h-[120px]">
                                            <button type="button" class="p-2 bg-neutral-dark/75 absolute top-0 right-0 hover:bg-neutral-dark" wire:click="confirmRemoval({{ $media->id }})">
                                                <x-heroicon-o-x class="w-6 h-6" />
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @if (sizeof($sampleMedia))
                            <div class="mt-4">
                                <p>Added Sample Media:</p>
                                <div>
                                    <div class="flex flex-wrap w-full">
                                        @foreach ($sampleMedia as $key => $media)
                                            <div class="w-40 h-32 mr-2 mt-2 flex justify-center items-center relative bg-primary border-4 border-dashed border-neutral-dark">
                                                <img src="{{ $media->temporaryUrl() }}" title="{{ $sampleMediaNames[$key] }}" alt="{{ $sampleMediaNames[$key] }}" class="max-w-[152px] max-h-[120px]">
                                                <button type="button" class="p-2 bg-neutral-dark/75 absolute top-0 right-0 hover:bg-neutral-dark" wire:click="removeNewMedia({{ $key}})">
                                                    <x-heroicon-o-x class="w-6 h-6" />
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Delete Media Confirmation Modal -->
                    <x-jet-confirmation-modal wire:model="confirmingRemoveMedia">
                        <x-slot name="title">
                            {{ __('Delete Media') }}
                        </x-slot>

                        <x-slot name="content">
                            {{ __('Are you sure you want to delete this media?') }}
                        </x-slot>

                        <x-slot name="footer">
                            <x-jet-secondary-button wire:click="$toggle('confirmingRemoveMedia')" wire:loading.attr="disabled">
                                {{ __('Cancel') }}
                            </x-jet-secondary-button>

                            <x-jet-danger-button class="ml-2" wire:click="removeMedia()" wire:loading.attr="disabled">
                                {{ __('Delete Media') }}
                            </x-jet-danger-button>
                        </x-slot>
                    </x-jet-confirmation-modal>
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
                        title: 'Basic Info',
                        /* component: 'social::pages.teams.partials.edit-team-basic' */
                    },
                    {
                        id: 1,
                        title: 'Locations',
                        /* component: 'social::pages.teams.partials.edit-team-locations' */
                    },
                    {
                        id: 2,
                        title: 'Media',
                    }
                ]
            }
        }
    </script>
@endpush
