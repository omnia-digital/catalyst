@extends('social::livewire.layouts.pages.full-page-layout')

@section('content')
    <div class="mr-4">
        <div class="mb-3 rounded-b-lg px-4 flex items-center justify-between bg-primary">
            <x-library::heading.1 class="py-4 hover:cursor-pointer">{{ Trans::get('Resources') }}</x-library::heading.1>
            <div class="flex items-center">
                @if(auth()->user()?->can('create', \Modules\Social\Models\Post::class))
                    @auth
                        <x-library::button
                                class="py-2 w-full h-10"
                                wire:click="$toggle('showPostEditor')"
                        >{{ \Trans::get('Add New Resource') }}</x-library::button>
                        <livewire:resources::pages.resources.create/>
                    @else
                        <x-library::button
                                class="py-2 w-full h-10"
                                wire:click="$toggle('showPostEditor')"
                        >{{ \Trans::get('Add New Resource') }}</x-library::button>
                        <livewire:authentication-modal/>
                    @endauth
                @endif
            </div>
        </div>

        @if($showPostEditor)
            <div class="my-4 mx-auto max-w-post-card-max-w">
                <x-library::heading.2 class="mb-2">{{ \Trans::get('Add New Resource') }}</x-library::heading.2>
                <livewire:social::news-feed-editor :postType="\Modules\Social\Enums\PostType::RESOURCE" submitButtonText="Add Resource" placeholder="What do you want to call this resource?"/>
            </div>
        @endif

        <div class="bg-secondary px-6 py-2 rounded-lg border-t border-b border-gray-100 sm:flex sm:items-center sm:justify-between">
            <nav class="flex space-x-8 py-2" aria-label="Global">
                <a href="{{ route('resources.home') }}" class="bg-neutral text-base-text-color inline-flex items-center rounded-md py-2 px-3 font-medium"
                   aria-current="page">
                    <x-library::icons.icon name="fa-regular fa-photo-film-music" size="w-5 h-5" class="pr-2"/>
                    All Resources</a>
                <a href="{{ route('resources.drafts') }}" class="text-base-text-color hover:bg-neutral hover:text-base-text-color inline-flex items-center rounded-md py-2 px-3
            font-medium">
                    <x-library::icons.icon name="fa-regular fa-pen-to-square" size="w-5 h-5" class="pr-2"/>
                    My Resources</a>
            </nav>
        </div>

        @if($showMyResources)
            {{-- Drafts/Published    --}}
            <div class="bg-secondary px-6 py-2 rounded-lg border-t border-b border-gray-100 sm:flex sm:items-center sm:justify-between">
                <nav class="flex space-x-8 py-2" aria-label="Global">
                    <a href="{{ route('resources.drafts') }}" class="bg-neutral text-base-text-color inline-flex items-center rounded-md py-2 px-3 font-medium"
                       aria-current="page">
                        <x-library::icons.icon name="fa-regular fa-pen-to-square" size="w-5 h-5" class="pr-2"/>
                        Drafts</a>
                    <a href="{{ route('resources.published') }}" class="text-base-text-color hover:bg-neutral hover:text-base-text-color inline-flex items-center rounded-md py-2 px-3
            font-medium">
                        <x-library::icons.icon name="fa-duotone fa-newspaper" size="w-5 h-5" class="pr-2"/>
                        Published</a>
                </nav>
            </div>
        @endif

        <!-- Filters -->
        @include('livewire.partials.filters', ['skipFilters' => ['members', 'location', 'tags']])

        <div class="">
            <div class="grid grid-cols-4">
                @forelse($resources as $post)
                    <div class="w-full break-inside">
                        <div class="">
                            <livewire:social::components.post-card-dynamic :post="$post" :wire:key="'post-card-' . $post->id"/>
                            {{--                        <livewire:resources::components.resource-card--}}
                            {{--                                as="li"--}}
                            {{--                                :post="$resource"--}}
                            {{--                                :wire:key="'resource-card-' . $resource->id"--}}
                            {{--                        />--}}
                        </div>
                    </div>
                @empty
                    <p class="p-4 bg-secondary rounded-md text-base-text-color">No resources to show</p>
                @endforelse
            </div>

            <div class="pb-6">
                {{ $resources->onEachSide(1)->links() }}
            </div>
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
@endsection
