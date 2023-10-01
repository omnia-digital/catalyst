@push('scripts')
    @auth
        @if (!Auth::user()->isImpersonating())
            <script>
                window.addEventListener('load', function () {
                    gist.identify("{{ Auth::user()?->id }}", {
                        email: "{{ Auth::user()?->email }}",
                        name: "{{ Auth::user()?->name }}",
                        first_name: "{{ Auth::user()?->first_name }}",
                        last_name: "{{ Auth::user()?->last_name }}",
                        livestream_account_id: {{ Auth::user()?->currentTeam?->livestreamAccount?->id }},
                        current_team_id: {{ Auth::user()?->currentTeam?->id }},
                        company_name: "{{ Auth::user()?->currentTeam?->name }}",
                        phone: "{{ Auth::user()?->person?->phone }}",
                        trial_ends_at: {{ Auth::user()?->currentTeam?->trial_ends_at?->timestamp }}
                    });

                    document.addEventListener('conversation:started', function (data) {
                        plausible('{{ config('plausible.events.chat-started') }}', {props: {team: {{ Auth::user()?->currentTeam?->id ?? 'guest' }}}})
                    }, false);
                });
            </script>
        @endif
    @endauth
@endpush
