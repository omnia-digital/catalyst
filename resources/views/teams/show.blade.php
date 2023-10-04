<x-app-layout>
    <x-slot name="header">
        <x-library::heading.2 class="font-semibold text-xl text-dark-text-color leading-tight">
            {{ Translate::get('Team Settings') }}
        </x-library::heading.2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @livewire('teams.update-team-name-form', ['team' => $team])

            @livewire('teams.team-member-manager', ['team' => $team])

            @if (Gate::check('delete', $team))
                <x-section-border/>

                <div class="mt-10 sm:mt-0">
                    @livewire('teams.delete-team-form', ['team' => $team])
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
