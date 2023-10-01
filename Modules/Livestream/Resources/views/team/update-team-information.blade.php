<x-form-section submit="updateTeamName">
    <x-slot name="title">
        {{ __('Organization') }}
    </x-slot>

    <x-slot name="description">
        {{ __('The organization\'s information.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Team Owner Information -->
        <div class="col-span-6">
            <x-label value="{{ __('Organization Owner') }}"/>

            <div class="flex items-center mt-2">
                <img class="w-12 h-12 rounded-full object-cover" src="{{ $team->owner->profile_photo_url }}"
                     alt="{{ $team->owner->name }}">

                <div class="ml-4 leading-tight">
                    <div>{{ $team->owner->name }}</div>
                    <div class="text-gray-700 text-sm">{{ $team->owner->email }}</div>
                </div>
            </div>
        </div>

        @if (request('alert'))
            <div class="col-span-6">
                @if ($team->owner->id === Auth::id())
                    <x-alert.danger>Please fill in your organization information to continue.</x-alert.danger>
                @else
                    <x-alert.danger>Please have your organization owner fill in this information to continue.
                    </x-alert.danger>
                @endif
            </div>
        @endif

        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Organization') }}"/>

            <x-input id="name"
                     type="text"
                     class="mt-1 block w-full"
                     wire:model="state.name"
                     :disabled="! Gate::check('update', $team)"/>

            <x-input-error for="name" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="phone" value="{{ __('Phone') }}"/>

            <x-input id="phone"
                     type="text"
                     class="mt-1 block w-full"
                     wire:model="state.phone"
                     :disabled="! Gate::check('update', $team)"/>

            <x-input-error for="phone" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="city" value="{{ __('City') }}"/>

            <x-input id="city"
                     type="text"
                     class="mt-1 block w-full"
                     wire:model="state.city"
                     :disabled="! Gate::check('update', $team)"/>

            <x-input-error for="city" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="state" value="{{ __('State / Region') }}"/>

            <x-input id="state"
                     type="text"
                     class="mt-1 block w-full"
                     wire:model="state.state"
                     :disabled="! Gate::check('update', $team)"/>

            <x-input-error for="state" class="mt-2"/>
        </div>

        <!-- Logo -->
        <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
            <!-- Logo File Input -->
            <input type="file" class="hidden"
                   wire:model.live="logo"
                   x-ref="logo"
                   x-on:change="
                        photoName = $refs.logo.files[0].name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            photoPreview = e.target.result;
                        };
                        reader.readAsDataURL($refs.logo.files[0]);
                   "/>

            <x-label for="logo" value="{{ __('Logo') }}"/>

            <!-- Current Logo -->
            <div class="mt-2" x-show="! photoPreview">
                <img src="{{ $team->logo }}" alt="{{ $team->name }}" class="rounded-full h-20 w-20 object-cover">
            </div>

            <!-- New Logo Preview -->
            <div class="mt-2" x-show="photoPreview">
                    <span class="block rounded-full w-20 h-20"
                          x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                    </span>
            </div>

            <x-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.logo.click()">
                {{ __('Select A New Logo') }}
            </x-secondary-button>

            @if ($team->photo_url)
                <x-secondary-button type="button" class="mt-2" wire:click="deleteLogo">
                    {{ __('Remove Logo') }}
                </x-secondary-button>
            @endif

            <x-input-error for="logo" class="mt-2"/>
        </div>
    </x-slot>

    @if (Gate::check('update', $team))
        <x-slot name="actions">
            <x-action-message class="mr-3" on="saved">
                {{ __('Saved.') }}
            </x-action-message>

            <x-button wire:loading.attr="disabled" wire:target="logo">
                {{ __('Save') }}
            </x-button>
        </x-slot>
    @endif
</x-form-section>
