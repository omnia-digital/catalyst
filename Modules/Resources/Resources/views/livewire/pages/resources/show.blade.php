@extends('social::livewire.layouts.pages.default-page-layout')

@section('content')
    @empty($resource)
        <x-library::heading.2>No Resource found</x-library::heading.2>
    @else
        <div class="mb-3 rounded-b-lg pl-4 flex items-center bg-primary">
            <div class="mr-4 p-2 rounded-full bg-secondary">
                <a href="{{ route('resources.home') }}">
                    <x-heroicon-o-arrow-left class="h-6"/>
                </a>
            </div>
            <a href="{{route('resources.home')}}">
                <x-library::heading.1 class="py-4 hover:cursor-pointer">{{ Trans::get('Resources') }}</x-library::heading.1>
            </a>
        </div>
        <div class="w-full">
            <div class="col-span-4 card">
                @if($resource->image)
                    <div>
                        <img class="rounded-lg rounded-b w-full object-cover max-h-96 bg-neutral-dark flex-shrink-0" src="{{$resource->image}}" alt="{{$resource->title}}">
                    </div>
                @endif
                <div class="px-6">
                    <div class="flex items-center space-x-2 mt-6">
                        <x-library::heading.3 class="text-2xl text-dark-text-color sm:text-4xl hover:underline font-bold">{{ $resource->title }}</x-library::heading.3>
                        @empty(!$resource->is_verified)
                            <x-heroicon-o-check-circle class="flex-shrink-0 w-6 h-6 inline-block  text-green-700 text-xs font-medium rounded-full"/>
                        @endempty
                    </div>
                    <div class="flex justify-start items-center my-2">
                        <div class="flex">
                            @if (is_null($resource->published_at))
                                <p class="italic text-base-text-color text-md"><span class="text-primary-400">Draft</span> created {{ $resource->created_at->format('M d, Y') }}</p>
                            @else
                                <x-heroicon-o-calendar class="w-5 h-5"/>
                                <p class="ml-2 text-base-text-color text-md">{{ $resource->published_at->format('M d, Y') }}</p>
                            @endif
                        </div>
                        <div class="flex ml-2 space-x-2">
                            <p>by</p>
                            <a href="{{ route('social.profile.show', $resource->user->handle) }}" class="hover:underline block text-base-text-color">{{  $resource->user->name }}</a>
                        </div>
                        @can('update', $resource)
                            <div class="ml-auto flex justify-end items-center">
                                <x-library::button.link href="{{ route('resources.edit', $resource->id) }}" size="" class="text-primary border-none rounded-none shadow-none hover:underline">
                                    Edit
                                </x-library::button.link>
                            </div>
                        @endcan
                    </div>

                    @empty(!$resource->tags)
                        <div class="flex justify-start space-x-2">
                            @foreach($resource->tags as $tag)
                                <x-tag :name="$tag->name" bg-color="neutral-dark" text-color="white"/>
                            @endforeach
                        </div>
                    @endempty

                    <div class="text-2xl my-6">
                        {!! $resource->body !!}
                    </div>

                    @if($resource->url)
                        <a href="{{ $resource->url }}" target="_blank" class="bg-primary hover:shadow-lg rounded-lg px-4 py-2 text-xl text-white-text-color inline-flex items-center space-x-2">
                            <p class="text-white-text-color">Go to URL</p>
                            <x-heroicon-o-arrow-right class="h-6 w-6"/>
                        </a>
                    @endif

                    <div>
                        <livewire:social::partials.post-actions wire:key="resource-actions-{{ $resource->id }}" :post="$resource" :show-comment-button="false" :show-bookmark-button="true"/>
                    </div>
                </div>
            </div>

            @if ($resource->isParent())
                <div class="py-4 justify-center w-full xl:w-3/4 2xl:1/2 m-auto max-w-post-card-max-w">
                    <div class="max-w-post-card-max-w">
                    <x-library::heading.3>{{ Trans::get('Discussion') }}</x-library::heading.3>
                    <livewire:social::comment-section :post="$resource" :type="\Modules\Social\Enums\PostType::RESOURCE"/>
                    </div>
                </div>
            @endif
        </div>
        <livewire:media-manager/>
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
                        component: 'social.resources'
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
