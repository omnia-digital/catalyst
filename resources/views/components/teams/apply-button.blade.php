<div>
    @auth
        @if ($team->teamApplications()->hasUser(auth()->id()))
            <div class="py-2 px-4 mx-2 inline-flex items-center text-sm rounded-full bg-neutral-dark text-white-text-color opacity-75 text-center">
                {{ Trans::get('Awaiting Approval') }}
                {{--    <button--}}
                {{--            class="py-2 px-4 mx-2 inline-flex items-center text-sm rounded-full bg-primary whitespace-nowrap hover:opacity-75 hover:underline"--}}
                {{--            wire:click="removeApplication"--}}
                {{--    >{{ \Trans::get('Remove') }}</button>--}}
            </div>
        @elseif(!$team->hasUser(auth()->user()))
            <div class="absolute -top-9 right-0 w-96">
                <x-jet-input-error for="user_id" class="mt-2"/>
            </div>
            @can('apply', $team)
                <button
                        class="py-2 px-4 mx-2 inline-flex items-center text-sm rounded-full bg-secondary text-white-text-color hover:opacity-75"
                        wire:click="applyToTeam"
                >{{ \App\Support\Platform\Platform::applyButtonText() }}</button>
            @endcan
        @endif
    @else
        <button
                class="py-2 px-4 mx-2 inline-flex items-center text-sm rounded-full bg-secondary text-white-text-color hover:opacity-75"
                wire:click.prevent="showLoginModal('{{ route('social.teams.show', $team) }}')"
        >{{ \App\Support\Platform\Platform::applyButtonText() }}</button>
    @endauth
</div>
