<x-app-layout>
    <x-slot name="header">
        <x-library::heading.2 class="font-semibold text-xl text-dark-text-color leading-tight">
            {{ Translate::get('Create Team') }}
        </x-library::heading.2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @livewire('teams.create-team-form')
        </div>
    </div>
</x-app-layout>
