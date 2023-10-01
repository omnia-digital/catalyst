<x-form-section submit="updateTeamName">
    <x-slot name="title">
        {{ Trans::get('Team Name') }}
    </x-slot>

    <x-slot name="description">
        {{ Trans::get('The team\'s name and owner information.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Team Owner Information -->
        <div class="col-span-6">
            <x-label value="{{ Trans::get('Team Owner') }}"/>

            <div class="flex items-center mt-2">
                <img class="w-12 h-12 rounded-full object-cover" src="{{ $team->owner->profile_photo_url }}"
                     alt="{{ $team->owner->name }}">

                <div class="ml-4 leading-tight">
                    <div>{{ $team->owner->name }}</div>
                    <div class="text-dark-text-color text-sm">{{ $team->owner->email }}</div>
                </div>
            </div>
        </div>

        <!-- Team Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ Trans::get('Team Name') }}"/>

            <x-input id="name"
                     type="text"
                     class="mt-1 block w-full"
                     wire:model.live="state.name"
                     :disabled="! Gate::check('update', $team)"/>

            <x-input-error for="name" class="mt-2"/>
        </div>
    </x-slot>

    @if (Gate::check('update', $team))
        <x-slot name="actions">
            <x-action-message class="mr-3" on="saved">
                {{ Trans::get('Saved.') }}
            </x-action-message>

            <x-button>
                {{ Trans::get('Save') }}
            </x-button>
        </x-slot>
    @endif
</x-form-section>
