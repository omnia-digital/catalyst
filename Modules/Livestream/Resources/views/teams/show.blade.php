<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Organization Settings') }}
            </h2>

            @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                <x-jet-dropdown-link href="{{ route('teams.create') }}">
                    {{ __('Create New Organization') }}
                </x-jet-dropdown-link>
            @endcan
        </div>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @livewire('team.update-team-information', ['team' => $team])

            @livewire('teams.team-member-manager', ['team' => $team])

            <x-jet-section-border/>

            @livewire('team.update-timezone')

            <x-jet-section-border/>

            @livewire('team.update-default-bible')

            @if (Gate::check('delete', $team) && ! $team->personal_team)
                <x-jet-section-border/>

                <div class="mt-10 sm:mt-0">
                    @livewire('teams.delete-team-form', ['team' => $team])
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            {{--window.addEventListener('load', (event) => {--}}
            {{--    const params = new Proxy(new URLSearchParams(window.location.search), {--}}
            {{--        get: (searchParams, prop) => searchParams.get(prop),--}}
            {{--    });--}}

            {{--    --}}{{--if (params.registered) {--}}
            {{--    --}}{{--    plausible('{{ config('plausible.events.user-registered') }}');--}}
            {{--    --}}{{--}--}}
            {{--});--}}
        </script>
    @endpush
</x-app-layout>
