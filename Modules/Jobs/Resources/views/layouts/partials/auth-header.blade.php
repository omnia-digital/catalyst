<div class="hidden sm:flex justify-center items-center text-white mt-4">
    <ul class="flex justify-center text-center md:-mx-8 ">
        <a href="{{ route('home') }}" class="mx-4 hover:font-bold">
            <li class="">Latest Jobs</li>
        </a>
        @if (Auth::user() && Auth::user()->hasRole('Client'))
            <a href="{{ route('jobs') }}" class="mx-4 hover:font-bold">
                <li class="">My Jobs</li>
            </a>
        @endif
        @if (Auth::user() && Auth::user()->isSuperAdmin())
            <a href="{{ \Laravel\Nova\Nova::path() }}" class="mx-4 hover:font-bold">
                <li class="">Admin</li>
            </a>
        @endif
    </ul>
</div>


<!-- Mobile menu, show/hide based on menu open state. -->
<div
    x-show="open"
    x-transition:enter="duration-150 ease-out"
    x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="duration-100 ease-in"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"
    class="sm:hidden mt-2"
>
    <div class="rounded-lg mx-2 bg-white text-gray-500 text-center" role="menu" aria-orientation="vertical" aria-labelledby="main-menu">
        <a href="{{ route('home') }}"
           class="block py-2 text-lg">
            Home
        </a>
        @if (Auth::user() && Auth::user()->hasRole('Client'))
            <a href="{{ route('jobs') }}"
               class="block py-2 text-lg">
                My Jobs
            </a>
        @endif
        @if (Auth::user() && Auth::user()->hasRole('Client'))
            <a href="{{ route('jobs.create') }}"
               class="block py-2 text-lg">
                New Job
            </a>
        @endif
        @if (Auth::user() && Auth::user()->isSuperAdmin())
            <a href="{{ \Laravel\Nova\Nova::path() }}"
               class="block py-2 text-lg">
                Admin
            </a>
        @endif
    </div>
</div>
