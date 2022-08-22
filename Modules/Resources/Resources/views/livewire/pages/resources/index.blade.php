@extends('resources::livewire.layouts.pages.full-page-layout')

@section('content')
        <div class="w-full mb-4">
            <div class="relative shadow-xl sm:rounded-b-2xl sm:overflow-hidden">
                <div class="absolute inset-0 grayscale">
                    <img class="h-full w-full object-cover"
                         src="https://images.unsplash.com/photo-1521737852567-6949f3f9f2b5?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=2830&q=80&sat=-100"
                         alt="People working on laptops">
                    <div class="absolute inset-0 bg-indigo-700 mix-blend-multiply"></div>
                </div>
                <div class="relative px-4 py-16 sm:px-6 sm:py-16 lg:py-16 lg:px-8">
                    <x-library::heading.1 class="text-center text-3xl font-extrabold tracking-tight sm:text-4xl lg:text-5xl">
                        <span class="block text-white uppercase">{{ Trans::get('Resources') }}</span>
                    </x-library::heading.1>
                    <p class="mt-6 max-w-lg mx-auto text-center text-xl text-indigo-200 sm:max-w-3xl">Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit
                        sunt amet fugiat veniam occaecat fugiat aliqua.</p>
                    <div class="mt-10 max-w-sm mx-auto sm:max-w-none sm:flex sm:justify-center">
                        <div class="justify-center w-full flex w-1/3">
                            <x-library::button x-data="" class="py-2 w-full h-10 bg-primary text-base-text-color" x-on:click.prevent.stop="$openModal('add-resource-modal')">
                                + New Resource
                            </x-library::button>
                            <livewire:resources::pages.resources.create/>
                        </div>
                    </div>
                </div>
            </div>
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
                            title: 'Top '.{{ \Trans::get('teams') }},
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
