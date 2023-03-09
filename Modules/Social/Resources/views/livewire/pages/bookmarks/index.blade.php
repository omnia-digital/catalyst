@extends('social::livewire.layouts.pages.default-page-layout')

@section('content')
    <div class="sticky top-[55px] z-40 mb-4 rounded-b-lg pl-4 flex items-center bg-primary items-center">
        <div class="flex-1 flex items-center">
            <x-library::icons.icon name="fa-regular fa-bookmark" color="text-secondary" class="h-8 w-8 mr-3"/>
            <x-library::heading.1 class="py-4">Bookmarks</x-library::heading.1>
        </div>
    </div>

    <div wire:init="showGuestAccessModal">
        @auth
            <!-- Filters -->
            @include('livewire.partials.filters', ['skipFilters' => ['location', 'members', 'tags']])

            @if(empty($bookmarks))
                <x-library::heading.2>No Bookmarked Resources</x-library::heading.2>
            @else
                <div class="">
                    <ul role="list" class="masonry masonry-2 space-y-4">
                        @foreach($bookmarks as $bookmark)
                            <li>
                                <livewire:social::components.post-card :post="$bookmark->bookmarkable()->first()"/>
                            </li>
                        @endforeach
                    </ul>

                    <div class="pb-6">
                        {{ $bookmarks->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        @endauth
    </div>

    <livewire:authentication-modal/>
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
                        title: 'Top '.{{ \Platform::getTeamsWordUpper() }},
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
