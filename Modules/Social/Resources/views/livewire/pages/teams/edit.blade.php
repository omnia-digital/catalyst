@extends('social::livewire.layouts.pages.full-page-layout')

{{--@section('full-width-header')--}}
{{--    <div class="col-span-2 h-36 bg-[url('https://source.unsplash.com/random')] -mx-4 bg-cover bg-no-repeat"></div>--}}
{{--@endsection--}}

@section('content')
    <div class="">
        <x-teams.partials.header :team="$team"/>

        <!-- Page Heading -->
        <div class="flex p-4 sticky items-center justify-between">
            <x-library::heading.2>{{ Trans::get('Team Admin Panel') }}</x-library::heading.2>

            <div class="flex justify-end items-center">
                @if ($errors->any())
                    <div class="mr-auto">
                        <p class="text-sm text-red-600">{{ Trans::get('This form has errors') }}:</p>
                        @foreach ($errors->all() as $error)
                            <p class="text-sm text-red-600">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                <div class="mr-4"><a href="{{ $team->profile() }}"
                                     class="hover:underline">{{ Trans::get('Cancel') }}</a></div>
                <x-library::button.index
                        wire:click.prevent="saveChanges"
                >{{ Trans::get('Save Changes') }}</x-library::button.index>
            </div>
        </div>

        <div x-data="setup()" class="px-4">
            <div>
                <!-- Team Edit Navigation -->
                <nav class="flex items-center text-xs">
                    <ul class="flex font-semibold border-b-2 border-gray-300 w-full pb-3 space-x-4">
                        <template x-for="(tab, index) in tabs" :key="tab.id">
                            <li class=" pb-[3px]">
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

            <!-- Edit Team Media -->
            <div x-cloak x-show="activeTab === 0" class="mt-6 grid grid-cols-2 gap-6">
                <x-library::heading.3>{{ Trans::get('Featured Content') }}</x-library::heading.3>
                <!-- Featured Content / Sample Media -->
                <div class="col-span-2">
                    <div class="flex items-center">
                        <x-library::input.label value="Uploaded Content"/>
                        <span class="text-red-600 text-sm ml-1">*</span>
                    </div>
                    <div class="flex justify-between items-center relative min-w-0 w-full border-gray-300 placeholder-gray-500 bg-secondary rounded focus:ring-primary focus:border-primary text-sm p-2">
                        <p class="flex-1 py-2 px-3 text-[1rem] text-base-text-color">Upload images/videos to display in
                            Featured section</p>
                        <label>
                            <input type="file" wire:model.live="sampleMedia" hidden multiple required/>
                            <span class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white-text-color bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neutral-light focus:ring-primary">Browse</span>
                        </label>
                    </div>
                    <x-library::input.error for="sampleMedia"/>
                    <div class="pb-8">
                        <div class="mt-4">
                            <p>Current Featured Content:</p>
                            <div>
                                @if ($team->sampleImages()->count())
                                    <div class="flex flex-wrap w-full">
                                        @foreach ($team->sampleImages() as $key => $media)
                                            <div class="w-40 h-32 mr-2 mt-2 flex justify-center items-center bg-secondary relative border-4 border-dashed border-neutral-dark">
                                                <img src="{{ $media->getFullUrl() }}" title="{{ $media->name }}"
                                                     alt="{{ $media->name }}" class="max-w-[152px] max-h-[120px]">
                                                <button type="button"
                                                        class="p-2 bg-neutral-dark/75 absolute top-0 right-0 hover:bg-neutral-dark"
                                                        wire:click="confirmRemoval({{ $media->id }})">
                                                    <x-library::icons.icon name="x-mark" class="w-6 h-6"/>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p>No featured content has been set.</p>
                                @endif
                            </div>
                        </div>
                        @if (sizeof($sampleMedia))
                            <div class="mt-4">
                                <p>Added Featured Content:</p>
                                <div>
                                    <div class="flex flex-wrap w-full">
                                        @foreach ($sampleMedia as $key => $media)
                                            <div class="w-40 h-32 mr-2 mt-2 flex justify-center items-center relative bg-secondary border-4 border-dashed border-neutral-dark">
                                                <img src="{{ $media->temporaryUrl() }}"
                                                     title="{{ $sampleMediaNames[$key] }}"
                                                     alt="{{ $sampleMediaNames[$key] }}"
                                                     class="max-w-[152px] max-h-[120px]">
                                                <button type="button"
                                                        class="p-2 bg-neutral-dark/75 absolute top-0 right-0 hover:bg-neutral-dark"
                                                        wire:click="removeNewMedia({{ $key }})">
                                                    <x-library::icons.icon name="x-mark" class="w-6 h-6"/>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Delete Media Confirmation Modal -->
                    <x-confirmation-modal wire:model.live="confirmingRemoveMedia">
                        <x-slot name="title">
                            {{ __('Delete Media') }}
                        </x-slot>

                        <x-slot name="content">
                            {{ __('Are you sure you want to delete this media?') }}
                        </x-slot>

                        <x-slot name="footer">
                            <x-secondary-button wire:click="$toggle('confirmingRemoveMedia')"
                                                wire:loading.attr="disabled">
                                {{ __('Cancel') }}
                            </x-secondary-button>

                            <x-danger-button class="ml-2" wire:click="removeMedia()" wire:loading.attr="disabled">
                                {{ __('Delete Media') }}
                            </x-danger-button>
                        </x-slot>
                    </x-confirmation-modal>
                </div>

                @if (Platform::isModuleEnabled('games'))
                    <x-library::heading.4 class="col-span-2">{{ Trans::get('Feeds') }}</x-library::heading.4>
                    <!-- YouTube Channel -->
                    <div class="flex-col">
                        <x-library::input.label value="YouTube Channel ID" class="inline"/>
                        <x-library::input.text id="youtube_channel_id" wire:model="team.youtube_channel_id"/>
                        <x-library::input.error for="team.youtube_channel_id"/>
                    </div>

                    <!-- Twitch Channel -->
                    <div class="flex-col">
                        <x-library::input.label value="Twitch Channel ID" class="inline"/>
                        <x-library::input.text id="twitch_channel_id" wire:model="team.twitch_channel_id"/>
                        <x-library::input.error for="team.twitch_channel_id"/>
                    </div>
                @endif

                <div class="col-span-2">
                    <x-library::heading.3>{{ Trans::get('Team Home & Profile') }}</x-library::heading.3>
                </div>
                <!-- Banner Image -->
                <div class="flex-col">
                    <div class="flex items-center">
                        <x-library::input.label value="Banner Image"/>
                        <span class="text-red-600 text-sm ml-1">*</span>
                    </div>
                    <div class="flex justify-between items-center relative min-w-0 w-full border-gray-300 placeholder-gray-500 bg-secondary rounded focus:ring-primary focus:border-primary text-sm p-2">
                        <input type="text" class="flex-1 border-none" wire:model.live="bannerImageName"
                               placeholder="Upload file for banner" readonly>
                        <label>
                            <input type="file" wire:model.live="bannerImage" hidden required/>
                            <span class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white-text-color bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neutral-light focus:ring-primary">Browse</span>
                        </label>
                    </div>
                    <x-library::input.error for="bannerImage"/>
                    <div class="flex mt-4 space-x-2">
                        <div>
                            <p>Current Banner:</p>
                            @if ($team->bannerImage()->count())
                                <img src="{{ $team->bannerImage()->getFullUrl() }}"
                                     alt="{{ $team->bannerImage()->name }}" title="{{ $team->bannerImage()->name }}"
                                     class="w-full h-32">
                            @else
                                <p>No image set for banner</p>
                            @endif
                        </div>
                        @if ($bannerImage)
                            <div>
                                <p>New Banner:</p>
                                <img class="w-full h-32" src="{{ $bannerImage->temporaryUrl() }}"
                                     alt="{{ $bannerImageName }} Preview">
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Profile Photo -->
                <div class="flex-col">
                    <div class="flex items-center">
                        <x-library::input.label value="{{ Trans::get('Team') }} Profile Photo"/>
                        <span class="text-red-600 text-sm ml-1">*</span>
                    </div>
                    <div class="flex justify-between items-center relative min-w-0 w-full border-gray-300 placeholder-gray-500 bg-secondary rounded focus:ring-primary focus:border-primary text-sm p-2">
                        <input type="text" class="flex-1 border-none" wire:model.live="profilePhotoName"
                               placeholder="Upload file for banner" readonly>
                        <label>
                            <input type="file" wire:model.live="profilePhoto" hidden required/>
                            <span class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white-text-color bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neutral-light focus:ring-primary">Browse</span>
                        </label>
                    </div>
                    <x-library::input.error for="profilePhoto"/>
                    <div class="flex mt-4 space-x-2">
                        <div>
                            <p>Current Profile Photo:</p>
                            @if ($team->profilePhoto()->count())
                                <img src="{{ $team->profilePhoto()->getFullUrl() }}"
                                     alt="{{ $team->profilePhoto()->name }}" title="{{ $team->profilePhoto()->name }}"
                                     class="w-full h-32">
                            @else
                                <p>No image set for profile photo</p>
                            @endif
                        </div>
                        @if ($profilePhoto)
                            <div>
                                <p>New Profile Photo:</p>
                                <img class="w-full h-32" src="{{ $profilePhoto->temporaryUrl() }}"
                                     alt="{{ $profilePhotoName }}">
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Main Image -->
                <div class="flex-col">
                    <div class="flex items-center">
                        <x-library::input.label value="Main Image"/>
                        <span class="text-red-600 text-sm">*</span>
                    </div>
                    <div class="flex justify-between items-center relative min-w-0 w-full border-gray-300 placeholder-gray-500 bg-secondary rounded focus:ring-primary focus:border-primary text-sm p-2">
                        <input type="text" class="flex-1 border-none" wire:model.live="mainImageName"
                               placeholder="Upload file for banner" readonly>
                        <label>
                            <input type="file" wire:model.live="mainImage" hidden required/>
                            <span class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white-text-color bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neutral-light focus:ring-primary">Browse</span>
                        </label>
                    </div>
                    <x-library::input.error for="mainImage"/>
                    <div class="flex mt-4 space-x-2">
                        <div>
                            <p>Current Main:</p>
                            @if ($team->mainImage()->count())
                                <img src="{{ $team->mainImage()->getFullUrl() }}" alt="{{ $team->mainImage()->name }}"
                                     title="{{ $team->mainImage()->name }}" class="w-full h-32">
                            @else
                                <p>No image set for main</p>
                            @endif
                        </div>
                        @if ($mainImage)
                            <div>
                                <p>New Main:</p>
                                <img class="w-full h-32" src="{{ $mainImage->temporaryUrl() }}"
                                     alt="{{ $mainImageName }}">
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Edit Basic Team Info -->
            <div x-show="activeTab === 1" class="mt-6 grid grid-cols-2 gap-6">
                {{-- {{ $this->form }} --}}
                <div class="flex-col">
                    <x-library::input.label value="Name" class="inline"/>
                    <span class="text-red-600 text-sm">*</span>
                    <x-library::input.text id="name" wire:model="team.name" required/>
                    <x-library::input.error for="team.name"/>
                </div>
                <div class="flex-col">
                    <x-library::input.label value="Start Date"/>
                    <x-library::input.date id="startDate" wire:model="team.start_date"
                                           placeholder="{{ Trans::get('Team Launch Date') }}"/>
                    <x-library::input.error for="startDate"/>
                </div>
                <div class="flex-col">
                    <x-library::input.label value="{{ Trans::get('Summary') }}"/>
                    <x-library::input.textarea id="summary" wire:model="team.summary"/>
                    <x-library::input.error for="team.summary"/>
                </div>
                <div class="flex-col">
                    <x-library::input.label value="{{ Trans::get('About this Team') }}"/>
                    <x-library::input.textarea id="content" wire:model="team.content" :rows="8"/>
                    <x-library::input.error for="team.content"/>
                </div>
                {{--                @livewire('teams.delete-team-form', ['team' => $team])--}}
            </div>

            <!-- Edit Team Location -->
            <div x-cloak x-show="activeTab === 2" class="mt-6 space-y-6">
                <div>
                    <x-library::heading.3 class="text-lg">Current Team Location</x-library::heading.3>
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
                    <x-library::heading.3 class="text-lg">Update Location</x-library::heading.3>
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
                        <x-library::heading.3 class="text-lg">New Team Location</x-library::heading.3>
                        <p>{{ $this->selectedAddress }}</p>
                        <p class="text-2xs text-red-600">Please save changes to use this address</p>
                    </div>
                @endif
            </div>

            <!-- Team Members -->
            <div x-cloak x-show="activeTab === 3" class="mt-6 pb-12 space-y-6">
                <div>
                    <livewire:social::pages.teams.members :team="$team"/>
                </div>
            </div>

            <!-- Forms -->
            <div x-cloak x-show="activeTab === 4" class="mt-6 pb-12 space-y-6">
                <div>
                    <livewire:social::pages.teams.forms :team="$team"/>
                </div>
            </div>

            <!-- Subscriptions -->
            <div x-cloak x-show="activeTab === 5" class="mt-6 pb-12 space-y-6">
                <div>
                    <livewire:billing::pages.admin-subscriptions :team="$team"/>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function setup() {
            return {
                activeTab: 5,
                tabs: [
                    {
                        id: 0,
                        title: 'Content',
                    },
                    {
                        id: 1,
                        title: 'Profile',
                        /* component: 'social::pages.teams.partials.edit-team-basic' */
                    },
                    {
                        id: 2,
                        title: 'Locations',
                        /* component: 'social::pages.teams.partials.edit-team-locations' */
                    },
                    {
                        id: 3,
                        title: 'Members',
                        // component: 'social::pages.teams.members'
                    },
                    {
                        id: 4,
                        title: 'Forms',
                    },
                    {
                        id: 5,
                        title: 'Subscriptions',
                    },
                ]
            }
        }
    </script>
@endpush
