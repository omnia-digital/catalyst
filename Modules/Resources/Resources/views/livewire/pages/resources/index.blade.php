@extends('resources::livewire.layouts.main-layout')

@section('content')
    <div class="flex space-x-6">
        <div class="max-w-2xl mx-auto">
            <div class="mb-2 flex justify-between items-center">
                <div class="flex-1 flex items-center">
                    <h1 class="py-2 text-3xl">Resources</h1>
                </div>

                <h2>

                <x-library::button x-data="" class="py-2 w-60 h-10" x-on:click.prevent="$openModal('add-resource-modal')">
                    Add Resource
                </x-library::button>
                </h2>
                <livewire:resources::pages.resources.create/>
            </div>

            <!-- Filters -->
            @include('livewire.partials.filters')

            <div class="">
                <ul role="list" class="space-y-4">
                    @foreach($resources as $resource)
                        <li>
                            <livewire:resources::components.resource-card
                                as="li"
                                :post="$resource"
                                :wire:key="'resource-card-' . $resource->id"
                            />
                        </li>
                    @endforeach
                </ul>

                <div class="pb-6">
                    {{ $resources->onEachSide(1)->links() }}
                </div>
            </div>
        </div>

        <x-sidebar-column class="max-w-sm" post-type="resource"/>
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
@endsection
