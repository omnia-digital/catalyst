@extends('social::livewire.layouts.pages.default-page-layout')

@section('content')
    <div class="sticky top-[55px] z-40 mb-4 rounded-b-lg pl-4 flex items-center bg-secondary items-center">
        <div class="flex-1 flex items-center">
            <h1 class="py-4 text-3xl text-primary hover:cursor-pointer">Bookmarks</h1>
        </div>
    </div>

    <!-- Filters -->
    @include('livewire.partials.filters', ['skipFilters' => ['location', 'members', 'tags']])

    @if(empty($bookmarks))
        <x-library::heading.2>No Bookmarked Resources</x-library::heading.2>
    @else
        <div class="">
            <ul role="list" class="grid grid-cols-1 gap-6">
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
                        title: 'Top ' . {{ \Trans::get('teams') }},
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
