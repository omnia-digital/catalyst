@extends('resources::livewire.layouts.main-layout')

@section('content')
    <div class="mb-4 flex items-center">
        <div class="mr-4 hover:bg-gray-300 p-2 rounded-full"><a href="{{ route('resources.home') }}" class="">
                <x-heroicon-o-arrow-left class="h-6"/>
            </a></div>
        <h1 class="py-2 text-3xl">Resource</h1>
    </div>
    <div class="xl:grid xl:grid-cols-9 xl:gap-9">
        <div class="xl:col-span-6">
            <div class="bg-white px-4 py-5 sm:px-6 rounded-lg">
                <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="{{ $resource->user->profile->name }}">
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900">
                            <a href="#" class="hover:underline">{{ $resource->user->profile->name }}</a>
                        </p>
                        <p class="text-sm text-gray-500">
                            <a href="#" class="hover:underline">{{ $resource->created_at->diffForHumans() }}</a>
                        </p>
                    </div>
                    <div class="flex-shrink-0 self-center flex">
                        <div class="relative z-30 inline-block text-left">
                            <x-library::dropdown>
                                <x-slot name="trigger">
                                    <button type="button" class="-m-2 p-2 rounded-full flex items-center text-gray-400 hover:text-gray-600" id="menu-0-button" aria-expanded="false" aria-haspopup="true">
                                        <span class="sr-only">Open options</span>
                                        <x-heroicon-s-dots-vertical class="h-5 w-5"/>
                                    </button>
                                </x-slot>
                                <x-library::dropdown.item>Report</x-library::dropdown.item>
                            </x-library::dropdown>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between py-4">
                    <div class="flex items-center space-x-3">
                        <x-library::heading.4>{{ $resource->title }}</x-library::heading.4>

                        @empty(!$resource->is_verified)
                            <x-heroicon-o-check-circle class="flex-shrink-0 w-6 h-6 inline-block  text-green-700 text-xs font-medium rounded-full"/>
                        @endempty
                    </div>

                    @if ($resource->tags)
                        <div class="flex justify-start space-x-2">
                            @foreach($post->tags as $tag)
                                <x-library::tag class="bg-gray-200">{{ $tag }}</x-library::tag>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="w-full pb-2">
                    {!! Purify::clean($resource->body) !!}
                </div>

                <div class="block w-full aspect-w-10 aspect-h-3 rounded-lg overflow-hidden">
                    <img src="{{ $resource->image }}" alt="{{ $resource->title }}" class="object-cover">
                </div>

                <div class="px-6">
                    <livewire:social::partials.post-actions :post="$resource"/>
                </div>

                <livewire:social::comment-section :post="$resource"/>
            </div>
        </div>

        <aside class="hidden xl:block xl:col-span-3">
            <div class="sticky h-screen overflow-y-scroll scrollbar-hide top-4 space-y-4 pb-36 bg-white shadow rounded-lg">
                <livewire:social::partials.trending-section title="Top Resources" type="resource"/>
                <livewire:social::partials.who-to-follow-section/>
                <livewire:social::partials.applications/>
            </div>
        </aside>
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
                        component: 'social.resources'
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
