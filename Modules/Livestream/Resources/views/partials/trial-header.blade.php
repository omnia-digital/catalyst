@if (Auth::user()->currentTeam->onTrial())
    <header class="w-full">
        <div class="flex-shrink-0 bg-blue-500 border-b border-gray-200 shadow-sm flex">
            <p class="w-full py-2 font-bold content-center text-center text-white">Trial ends
                on {{ Auth::user()->currentTeam->trial_ends_at->format('M jS, Y') }}</p>
        </div>
    </header>
@endif
