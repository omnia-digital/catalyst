@extends('resources::livewire.layouts.pages.full-page-layout')

@section('content')
            <div class="mb-2 flex justify-between items-center">
                <div class="flex-1 flex items-center">
{{--                    <div class="mr-4 hover:bg-neutral-dark p-2 rounded-full">--}}
{{--                        <a href="{{ route('social.home') }}">--}}
{{--                            <x-heroicon-o-arrow-left class="h-6"/>--}}
{{--                        </a>--}}
{{--                    </div>--}}
                    <h1 class="py-2 text-3xl">Resources</h1>
                </div>

                <h2>

                <x-library::button x-data="" class="py-2 w-60 h-10" x-on:click.prevent.stop="$openModal('add-resource-modal')">
                    Add Resource
                </x-library::button>
                </h2>
                <livewire:resources::pages.resources.create/>
            </div>

            <!-- Filters -->
            @include('livewire.partials.filters', ['skipFilters' => ['members', 'location', 'tags']])

            <div class="">
                <div class="masonry sm:masonry-2">
                    @forelse($resources as $resource)
                        <div class="w-full break-inside mb-3">
                            <div class="mx-1">
                            <livewire:resources::components.resource-card
                                as="li"
                                :post="$resource"
                                :wire:key="'resource-card-' . $resource->id"
                            />
                            </div>
                        </div>
                    @empty
                        <li class="p-4 bg-primary rounded-md text-base-text-color">No resources to show</li>
                    @endforelse
                </div>

                <div class="pb-6">
                    {{ $resources->onEachSide(1)->links() }}
                </div>
            </div>
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
@endsection
