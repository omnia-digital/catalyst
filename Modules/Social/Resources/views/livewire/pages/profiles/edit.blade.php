@extends('social::livewire.layouts.user-profile-layout')

@section('full-width-header')
    <div class="col-span-2 h-36 bg-[url('https://source.unsplash.com/random')] -mx-4 bg-cover bg-no-repeat"></div>
@endsection

@section('content')
<div>
    <!-- Page Heading -->
    <div class="space-y-8">
        <div class="border-b-2 border-b-light-text-color pb-1">
            <h1 class="text-3xl"><span class="text-dark-text-color">Edit Profile: </span><span class="text-light-text-color">{{ $profile->name }}</span></h1>
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
            <p class="text-sm opa text-green-600">Profile saved.</p>
        </div>
        <div class="mr-4"><a href="{{ $profile->url() }}" class="hover:underline">Cancel</a></div>
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

        <!-- Edit Basic User Info -->
        <div x-show="activeTab === 0" class="mt-6 space-y-6">
            <div>
                <x-library::input.label value="First Name" class="inline"/><span class="text-red-600 text-sm">*</span>
                <x-library::input.text id="first_name" wire:model.defer="profile.first_name" required/>
                <x-library::input.error for="first_name"/>
            </div>
            <div>
                <x-library::input.label value="Last Name" class="inline"/><span class="text-red-600 text-sm">*</span>
                <x-library::input.text id="last_name" wire:model.defer="profile.last_name" required/>
                <x-library::input.error for="last_name"/>
            </div>
            <div>
                <x-library::input.label value="Bio"/>
                <x-library::input.textarea id="bio" wire:model.defer="profile.bio"/>
                <x-library::input.error for="bio"/>
            </div>
        </div>

        <!-- Edit Team Location -->
        <div x-cloak x-show="activeTab === 1" class="mt-6 space-y-6">

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
                        title: 'Other',
                    }
                ]
            }
        }
    </script>
@endpush
