<x-library::modal id="create-team">
    <x-slot name="title">{{ \Trans::get('Create Team') }}</x-slot>

    <x-slot name="content">
        <div>
            <div class="flex items-center">
                <x-library::input.label value="{{ \Trans::get('Name') }}" /><span class="text-red-600 text-sm ml-1">*</span>
            </div>
            <x-library::input.text wire:model.defer="name" class="bg-primary" placeholder="{{ \Trans::get('Enter your Team Name') }}" required/>
            <x-library::input.error for="name"/>
        </div>
        <div class="mt-6">
            <div class="flex items-center">
                <x-library::input.label value="{{ \Trans::get('What type of Team is this?') }}" /><span class="text-red-600 text-sm ml-1">*</span>
            </div>
            <p class="text-neutral-dark">{{ \Trans::get('(you can choose more than one)') }}</p>
            <x-library::input.selects wire:model="teamTypes" :options="$teamTags"/>
        </div>
{{--        <div class="mt-6">--}}
{{--            // @TODO [Josh] - we can allow the user to choose a resource within the platform like a User, Game, Post, etc.--}}
{{--            We should probably have this listed as an array somewhere like--}}
{{--            $teamFocusResources = ['User', 'Game', 'Post', 'Event', 'Other'];--}}
{{--            <div class="flex items-center">--}}
{{--                <x-library::input.label value="{{ \Trans::get('Team Focus') }}" /><span class="text-red-600 text-sm ml-1">*</span>--}}
{{--            </div>--}}
{{--            <p class="text-neutral-dark">{{ \Trans::get('Do you want this Team to be focused on something?') }}</p>--}}
{{--            <x-library::input.selects wire:model="teamFocus" :options="$teamFocuses" max="1"/>--}}
{{--        </div>--}}
{{--        <div class="mt-6">--}}
{{--            <div class="flex items-center">--}}
{{--                <x-library::input.label value="{{ \Trans::get('Start Date (can be changed later)') }}"/><span class="text-red-600 text-sm ml-1">*</span>--}}
{{--            </div>--}}
{{--            <x-library::input.date wire:model.defer="startDate" placeholder="{{ \Trans::get('Team Launch Date') }}"/>--}}
{{--            <x-library::input.error for="startDate"/>--}}
{{--        </div>--}}
{{--        <div class="mt-6">--}}
{{--            <div class="flex items-center">--}}
{{--                <x-library::input.label value="{{ \Trans::get('Summary') }}"/><span class="text-red-600 text-sm ml-1">*</span>--}}
{{--            </div>--}}
{{--            <x-library::input.textarea wire:model.defer="summary" maxlength="280" placeholder="{{ \Trans::get('Summary') }}" />--}}
{{--            <x-library::input.error for="summary"/>--}}
{{--        </div>--}}
{{--        <div class="mt-6">--}}
{{--            <hr class="border-neutral-dark mt-6 mb-4"/>--}}
{{--            <h3 class="text-xl mb-4">{{ \Trans::get('Media') }}</h3>--}}
{{--            <div class="flex items-center">--}}
{{--                <x-library::input.label value="{{ \Trans::get('Banner Image') }}" /><span class="text-red-600 text-sm ml-1">*</span>--}}
{{--            </div>--}}
{{--            <div class="flex justify-between items-center relative min-w-0 w-full border-neutral placeholder-neutral-dark bg-primary rounded focus:ring-secondary focus:border-secondary text-sm p-2">--}}
{{--                <input type="text" class="flex-1 border-none" wire:model="bannerImageName" placeholder="{{ \Trans::get('Upload file for banner') }}" readonly>--}}
{{--                <label>--}}
{{--                    <input type="file" wire:model="bannerImage" hidden required />--}}
{{--                    <span class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-primary bg-secondary hover:bg-secondary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neutral-light focus:ring-secondary">{{ \Trans::get('Browse') }}</span>--}}
{{--                </label>--}}
{{--            </div>--}}
{{--            <x-library::input.error for="bannerImage" />--}}
{{--            @if ($bannerImage)--}}
{{--                <div>--}}
{{--                    <p>{{ \Trans::get('Banner Preview') }}:</p>--}}
{{--                    <img class="w-full h-52" src="{{ $bannerImage->temporaryUrl() }}" alt="{{ $bannerImageName }} Preview">--}}
{{--                </div>--}}
{{--            @endif--}}

            <!-- Profile Photo -->
{{--            <hr class="my-4 border-neutral-light">--}}
{{--            <div>--}}
{{--                <div class="flex items-center">--}}
{{--                    <x-library::input.label value="{{ Trans::get('Team') }} Profile Photo" />--}}
{{--                </div>--}}
{{--                <div class="flex justify-between items-center relative min-w-0 w-full border-gray-300 placeholder-gray-500 bg-primary rounded focus:ring-secondary focus:border-secondary text-sm p-2">--}}
{{--                    <input type="text" class="flex-1 border-none" wire:model="profilePhotoName" placeholder="Upload file for profile photo" readonly>--}}
{{--                    <label>--}}
{{--                        <input type="file" wire:model="profilePhoto" hidden />--}}
{{--                        <span class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-secondary hover:bg-secondary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neutral-light focus:ring-secondary">Browse</span>--}}
{{--                    </label>--}}
{{--                </div>--}}
{{--                <x-library::input.error for="profilePhoto" />--}}
{{--                @if ($profilePhoto)--}}
{{--                    <div>--}}
{{--                        <p>New Photo:</p>--}}
{{--                        <img class="w-full h-32" src="{{ $profilePhoto->temporaryUrl() }}" alt="{{ $profilePhotoName }}">--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            </div>--}}

            <!-- Main Image -->
{{--            <hr class="my-4 border-neutral-light">--}}
{{--            <div class="flex items-center mt-4">--}}
{{--                <x-library::input.label value="{{ \Trans::get('Main Image') }}" /><span class="text-red-600 text-sm ml-1">*</span>--}}
{{--            </div>--}}
{{--            <div class="flex justify-between items-center relative min-w-0 w-full border-neutral placeholder-neutral-dark bg-primary rounded focus:ring-secondary focus:border-secondary text-sm p-2">--}}
{{--                <input type="text" class="flex-1 border-none" wire:model="mainImageName" placeholder="{{ \Trans::get('Upload file for banner') }}" readonly>--}}
{{--                <label>--}}
{{--                    <input type="file" wire:model="mainImage" hidden required />--}}
{{--                    <span class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-primary bg-secondary hover:bg-secondary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neutral-light focus:ring-secondary">{{ \Trans::get('Browse') }}</span>--}}
{{--                </label>--}}
{{--            </div>--}}
{{--            <x-library::input.error for="mainImage" />--}}
{{--            @if ($mainImage)--}}
{{--                <div>--}}
{{--                    <p>{{ \Trans::get('Main Preview') }}:</p>--}}
{{--                    <img class="w-full h-52" src="{{ $mainImage->temporaryUrl() }}" alt="{{ $mainImageName }}">--}}
{{--                </div>--}}
{{--            @endif--}}

{{--            <!-- Sample Images -->--}}
{{--            <hr class="my-4 border-neutral-light">--}}
{{--            <div class="flex items-center mt-4">--}}
{{--                <x-library::input.label value="{{ \Trans::get('Sample Media') }}" /><span class="text-red-600 text-sm ml-1">*</span>--}}
{{--            </div>--}}
{{--            <div class="flex justify-between items-center relative min-w-0 w-full border-neutral placeholder-neutral-dark bg-primary rounded focus:ring-secondary focus:border-secondary text-sm p-2">--}}
{{--                <p class="flex-1 py-2 px-3 text-[1rem] text-base-text-color">{{ \Trans::get('Upload multiple images to show off your team') }}</p>--}}
{{--                <label>--}}
{{--                    <input type="file" wire:model="sampleMedia" hidden multiple required />--}}
{{--                    <span class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-primary bg-secondary hover:bg-secondary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neutral-light focus:ring-secondary">{{ \Trans::get('Browse') }}</span>--}}
{{--                </label>--}}
{{--            </div>--}}
{{--            <x-library::input.error for="sampleMedia" />--}}
{{--            @if (sizeof($sampleMedia))--}}
{{--                <div>--}}
{{--                    <p>{{ \Trans::get('Sample Media Preview') }}:</p>--}}
{{--                    <div class="mt-3 rounded-lg overflow-hidden">--}}
{{--                        <div class="grid grid-cols-{{ sizeof($sampleMedia) > 1 ? '2' : '1' }} grid-rows-{{ sizeof($sampleMedia) > 2 ? '2 h-80' : '1' }} gap-px">--}}
{{--                            @foreach ($sampleMedia as $key => $media)--}}
{{--                                <div class="w-full overflow-hidden @if($loop->odd && $loop->last) col-span-2 fill-row-span @endif">--}}
{{--                                    <img src="{{ $media->temporaryUrl() }}" title="{{ $sampleMediaNames[$key] }}" alt="{{ $sampleMediaNames[$key] }}" class="object-cover w-full">--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        </div>--}}
    </x-slot>

    <x-slot name="actions">
        <x-library::button wire:click.prevent="create" wire:target="create">{{ \Trans::get('Create') }}</x-library::button>
    </x-slot>

</x-library::modal>
