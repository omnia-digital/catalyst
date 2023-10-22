@php use Modules\Social\Models\Post; @endphp
@extends('catalyst-catalyst::livewire.layouts.pages.sidebar-page-layout')

@section('content')
    <div class="mb-3 rounded-b-lg px-4 flex items-center justify-between bg-primary">
        <x-library::heading.1 class="py-4 hover:cursor-pointer">{{ Translate::get('Articles') }}</x-library::heading.1>
        <div class="flex items-center">
            @if (auth()->user()->can('create', Post::class))
                @auth
                    <x-library::button.link
                            href="{{ route('articles.create') }}"
                            class="py-2 w-full h-10"
                    >{{ Translate::get('Add Article') }}</x-library::button.link>
                    <livewire:articles::pages.articles.create/>
                @else
                    <x-library::button
                            class="py-2 w-full h-10"
                            wire:click="loginCheck"
                    >{{ Translate::get('Add Article') }}</x-library::button>
                    <livewire:catalyst::authentication-modal/>
                @endauth
            @endif
        </div>
    </div>

    {{--    <div class="mx-auto max-w-post-card-max-w">--}}
    {{--        <livewire:catalyst-catalyst::news-feed-editor/>--}}
    {{--    </div>--}}

    <div class="bg-secondary px-6 py-2 rounded-lg border-t border-b border-gray-100 sm:flex sm:items-center sm:justify-between">
        <nav class="flex space-x-8 py-2" aria-label="Global">
            <a href="{{ route('articles.home') }}"
               class="bg-neutral text-base-text-color inline-flex items-center rounded-md py-2 px-3 font-medium"
               aria-current="page">
                <x-library::icons.icon name="fa-regular fa-photo-film-music" size="w-5 h-5" class="pr-2"/>
                All Articles</a>
            <a href="{{ route('articles.drafts') }}" class="text-base-text-color hover:bg-neutral hover:text-base-text-color inline-flex items-center rounded-md py-2 px-3
            font-medium">
                <x-library::icons.icon name="fa-regular fa-pen-to-square" size="w-5 h-5" class="pr-2"/>
                My Articles</a>
        </nav>
    </div>

    @if ($showMyArticles)
        {{-- Drafts/Published    --}}
        <div class="bg-secondary px-6 py-2 rounded-lg border-t border-b border-gray-100 sm:flex sm:items-center sm:justify-between">
            <nav class="flex space-x-8 py-2" aria-label="Global">
                <a href="{{ route('articles.drafts') }}"
                   class="bg-neutral text-base-text-color inline-flex items-center rounded-md py-2 px-3 font-medium"
                   aria-current="page">
                    <x-library::icons.icon name="fa-regular fa-pen-to-square" size="w-5 h-5" class="pr-2"/>
                    Drafts</a>
                <a href="{{ route('articles.published') }}" class="text-base-text-color hover:bg-neutral hover:text-base-text-color inline-flex items-center rounded-md py-2 px-3
            font-medium">
                    <x-library::icons.icon name="fa-duotone fa-newspaper" size="w-5 h-5" class="pr-2"/>
                    Published</a>
            </nav>
        </div>
    @endif

    <!-- Filters -->
    @include('livewire.partials.filters', ['skipFilters' => ['members', 'location', 'tags']])

    <div class="">
        <div class="masonry sm:masonry-1 md:masonry-2">
            @forelse ($articles as $post)
                <div class="w-full break-inside mb-3">
                    <div class="">
                        <livewire:catalyst-catalyst::components.post-card-dynamic :post="$post"
                                                                       :wire:key="'post-card-' . $post->id"/>
                        {{--                        <livewire:articles::components.article-card--}}
                        {{--                                as="li"--}}
                        {{--                                :post="$article"--}}
                        {{--                                :wire:key="'article-card-' . $article->id"--}}
                        {{--                        />--}}
                    </div>
                </div>
            @empty
                <p class="p-4 bg-secondary rounded-md text-base-text-color">No articles to show</p>
            @endforelse
        </div>

        <div class="pb-6">
            {{ $articles->onEachSide(1)->links() }}
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
                            title: 'Top '.{{ Catalyst::getTeamsWordUpper() }},
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
