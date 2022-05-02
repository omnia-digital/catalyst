@extends('resources::livewire.layouts.main-layout')

@section('content')
    <div class="flex space-x-6">
        <div class="max-w-2xl mx-auto">
            <div class="mb-2 flex justify-between items-center">
                <div class="mr-4 hover:bg-neutral-dark p-2 rounded-full">
                    <a href="{{ route('resources.home') }}">
                        <x-heroicon-o-arrow-left class="h-6"/>
                    </a>
                </div>
                <div class="flex-1 flex items-center">
                    <h1 class="py-2 text-3xl">Bookmarks</h1>
                </div>
            </div>

            <!-- Filters -->
            @include('livewire.partials.filters')

            @if(empty($bookmarks))
                <h2>No Bookmarked Resources</h2>
            @else
                <div class="">
                    <ul role="list" class="grid grid-cols-1 gap-6">
                        @foreach($bookmarks as $bookmark)
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
        </div>

        <x-sidebar-column class="max-w-sm" post-type="resource"/>
    </div>
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
                        title: 'Top Projects',
                        component: 'social.top-projects'
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
                notifications: '<span class="ml-2 text-xs w-5 h-5 flex items-center justify-center text-white bg-black rounded-full">3</span>',
            }
        }
    </script>
@endpush