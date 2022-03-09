@extends('social::livewire.layouts.main-layout')

@section('content')

    <!-- Filters -->
    @include('livewire.partials.filters')

    <div class="">
        <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            @foreach($bookmarks as $bookmark)
                <li>
                    @if($bookmark->bookmarkable()->first()->type === 'resource')
                        <livewire:resources::components.resource-card
                                :post="$bookmark->bookmarkable()->first()"/>
                    @else
                        <livewire:social::components.bookmark-card
                                :post="$bookmark->bookmarkable()->first()"/>
                    @endif
                </li>
            @endforeach
        </ul>
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
