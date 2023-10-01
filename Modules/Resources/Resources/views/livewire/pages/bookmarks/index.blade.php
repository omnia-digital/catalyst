@extends('resources::livewire.layouts.pages.sidebar-page-layout')

@section('content')
    <div class="mb-2 flex justify-between items-center">
        <div class="mr-4 hover:bg-neutral-dark p-2 rounded-full">
            <a href="{{ route('resources.home') }}">
                <x-heroicon-o-arrow-left class="h-6"/>
            </a>
        </div>
        <div class="flex-1 flex items-center">
            <x-library::heading.1 class="py-2">Bookmarks</x-library::heading.1>
        </div>
    </div>

    <!-- Filters -->
    @include('livewire.partials.filters', ['skipFilters' => ['location', 'members', 'tags']])

    @if (empty($bookmarks))
        <x-library::heading.2>No Bookmarked Resources</x-library::heading.2>
    @else
        <div class="">
            <ul role="list" class="grid grid-cols-1 gap-6">
                @foreach ($bookmarks as $bookmark)
                    <li>
                        <livewire:resources::components.resource-card
                                :post="$bookmark->bookmarkable()->first()"/>
                    </li>
                @endforeach
            </ul>

            <div class="pb-6">
                {{ $bookmarks->onEachSide(1)->links() }}
            </div>
        </div>
    @endif
@endsection
@push('scripts')
    <script>
        function setup() {
            return {
                activeTab: 0,
                tabs: [
                    {
                        id: 0,
                        title: 'My Feed',
                        component: 'social.posts'
                    },
                    {
                        id: 1,
                        title: 'Top '.{{ Platform::getTeamsWordUpper() }},
                        component: 'social.top-teams'
                    },
                    {
                        id: 2,
                        title: 'Newest',
                        component: 'social.newest'
                    },
                    {
                        id: 3,
                        title: 'Favorites',
                        component: 'social.favorites'
                    },
                    {
                        id: 4,
                        title: 'Undiscovered',
                        component: 'social.undiscovered'
                    },
                ],
                notifications: '<span class="ml-2 text-xs w-5 h-5 flex items-center justify-center text-white-text-color bg-black rounded-full">3</span>',
            }
        }
    </script>
@endpush
