@extends('social::livewire.layouts.pages.user-profile-layout')

@section('full-width-header')
    <x-profiles.partials.header :user="$profile->user"/>
@endsection

@section('content')
    <div class="px-4 lg:px-4 lg:pr-4">
        <!-- Page Heading -->
        <div class="mt-6 flex justify-between items-center">
            <x-library::heading.2 class="text-2xl">Edit Profile</x-library::heading.2>
            <div
                    x-data="{show: false}"
                    x-init="@this.on('changes_saved', () => {
                show = true;
                setTimeout(() => { show = false; }, 3000);
            })"
                    class="flex justify-end items-center"
            >
                @if ($errors->all())
                    <div class="mr-auto">
                        <p class="text-sm text-danger-600">There are errors in your form.</p>
                    </div>
                @endif
                <div class="mr-auto"
                     x-show="show"
                     x-transition:leave.opacity.duration.1500ms
                     style="display: none;"
                >
                    <p class="text-sm text-green-600">Profile saved.</p>
                </div>
                <div class="mr-4"><a href="{{ $profile->urlLink() }}" class="hover:underline">Cancel</a></div>
                <x-library::button.index
                        wire:click.prevent="saveChanges"
                >Save Changes
                </x-library::button.index>
            </div>
        </div>

        <div x-data="setup()">
            <!-- Team Edit Navigation -->
            <div class="w-full mt-6">
                <nav class="flex items-center justify-between text-xs">
                    <ul class="flex font-semibold border-b-2 border-gray-300 w-full pb-3">
                        <template x-for="(tab, index) in tabs" :key="tab.id">
                            <li class="px-4">
                                <a href="#"
                                   class="relative text-gray-400 transition duration-150 ease-in border-b-2 border-transparent pb-4 hover:border-dark-text-color focus:border-dark-text-color"
                                   :class="(activeTab === tab.id) && 'border-dark-text-color text-dark-text-color'"
                                   x-on:click.prevent="activeTab = tab.id;"
                                >
                                    <span x-text="tab.title"></span>
                                    @if ($errors->has('profile.*') || $errors->has('country') || $errors->has('profileTypes'))
                                        <template x-if="(tab.id === 0)">
                                            <span class="text-3xs text-danger-600 absolute -right-1 -top-1">{{ $errors->count() }}</span>
                                        </template>
                                    @endif
                                    @if ($errors->has('bannerImage') || $errors->has('image'))
                                        <template x-if="(tab.id === 1)">
                                            <span class="text-3xs text-danger-600 absolute -right-1 -top-1">{{ $errors->count() }}</span>
                                        </template>
                                    @endif
                                </a>
                            </li>
                        </template>
                    </ul>

                </nav>
            </div>

            <!-- Edit Basic User Info -->
            <div x-show="activeTab === 0" class="mt-6 grid grid-cols-4 gap-6">
                <div class="col-span-4 md:col-span-2">
                    <x-library::input.label value="First Name" class="inline"/>
                    <span class="text-red-600 text-sm">*</span>
                    <x-library::input.text id="first_name" wire:model="profile.first_name" required/>
                    <x-library::input.error for="profile.first_name"/>
                </div>
                <div class="col-span-4 md:col-span-2">
                    <x-library::input.label value="Last Name" class="inline"/>
                    <span class="text-red-600 text-sm">*</span>
                    <x-library::input.text id="last_name" wire:model="profile.last_name" required/>
                    <x-library::input.error for="profile.last_name"/>
                </div>
                <div class="col-span-4 md:col-span-2">
                    <x-library::input.label value="Website"/>
                    <x-library::input.text id="website" wire:model="profile.website"/>
                    <x-library::input.error for="profile.website"/>
                </div>
                <div class="col-span-4 md:col-span-2">
                    <x-library::input.label value="Date of Birth" class="inline"/>
                    <span class="text-neutral-dark ml-1">{{ Trans::get('(This will not be visible to the public)') }}</span>
                    <span class="text-red-600 text-sm">*</span>
                    <x-library::input.date format="Y-m-d" id="birth_date" wire:model="profile.birth_date"/>
                    <x-library::input.error for="profile.birth_date"/>
                </div>
                <div class="col-span-4 md:col-span-2">
                    <x-library::input.label value="Country" class="inline"/>
                    <span class="text-red-600 text-sm">*</span>
                    <x-library::input.select
                            :options="$countries"
                            placeholder="Select a Country"
                            class="!bg-white"
                            id="country"
                            wire:model.live="country"
                    />
                    <x-library::input.error for="country"/>
                </div>
                <div class="col-span-4">
                    <div class="flex items-center">
                        <x-library::input.label value="{{ Trans::get('What type of profile is this?') }}"
                                                class="inline"/>
                        <span class="text-neutral-dark ml-1">{{ Trans::get('(you can choose more than one)') }}</span>
                        <span class="text-red-600 text-sm">*</span>
                    </div>
                    <x-library::input.selects
                            wire:model.live="profileTypes"
                            :options="$this->profileTags"
                            :placeholder="sizeof($this->profileTags) ? 'Type to search' : 'There are currently no available tags.'"
                    />
                    <x-library::input.error for="profileTypes"/>
                    <p>Current Tags:</p>
                    <div class="flex items-center space-x-3">
                        @foreach ($profile->tags as $tag)
                            <div class="relative">
                                <x-tag bgColor="neutral-dark" textColor="white" class="text-lg px-4"
                                       :name="$tag->name"/>
                                <button
                                        wire:click="removeTag('{{ $tag->name }}')"
                                        class="absolute -top-2 -right-2 p-1 rounded-full bg-white"
                                >
                                    <x-library::icons.icon name="x-mark" color="text-danger-600" class="h-3 w-3"/>
                                </button>
                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="col-span-4">
                    <x-library::input.label value="Bio"/>
                    <x-library::input.textarea id="bio" wire:model="profile.bio"/>
                    <x-library::input.error for="profile.bio"/>
                </div>

            </div>

            <!-- Edit Team Media -->
            <div x-cloak x-show="activeTab === 1" class="mt-6 space-y-6">
                <div class="space-y-4">
                    <!-- Banner Image -->
                    <div>
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
                                @if ($profile->bannerImage()->count())
                                    <img src="{{ $profile->bannerImage()->getFullUrl() }}"
                                         alt="{{ $profile->bannerImage()->name }}"
                                         title="{{ $profile->bannerImage()->name }}" class="w-full h-32">
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
                    <hr class="my-4 border-neutral-dark">
                    <div>
                        <div class="flex items-center">
                            <x-library::input.label value="Profile Photos"/>
                            <span class="text-red-600 text-sm ml-1">*</span>
                        </div>
                        <div class="flex justify-between items-center relative min-w-0 w-full border-gray-300 placeholder-gray-500 bg-secondary rounded focus:ring-primary focus:border-primary text-sm p-2">
                            <input type="text" class="flex-1 border-none" wire:model.live="photoName"
                                   placeholder="Upload file for banner" readonly>
                            <label>
                                <input type="file" wire:model.live="photo" hidden required/>
                                <span class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white-text-color bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neutral-light focus:ring-primary">Browse</span>
                            </label>
                        </div>
                        <x-library::input.error for="photo"/>
                        <div class="flex mt-4 space-x-2">
                            <div>
                                <p>Current Photo:</p>
                                @if ($profile->photo()->count())
                                    <img src="{{ $profile->photo()->getFullUrl() }}" alt="{{ $profile->photo()->name }}"
                                         title="{{ $profile->photo()->name }}" class="w-full h-32">
                                @else
                                    <p>No image set for photo</p>
                                @endif
                            </div>
                            @if ($photo)
                                <div>
                                    <p>New Photo:</p>
                                    <img class="w-full h-32" src="{{ $photo->temporaryUrl() }}" alt="{{ $photoName }}">
                                </div>
                            @endif
                        </div>
                    </div>
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
                    },
                    {
                        id: 1,
                        title: 'Media',
                    }
                ]
            }
        }
    </script>
@endpush
