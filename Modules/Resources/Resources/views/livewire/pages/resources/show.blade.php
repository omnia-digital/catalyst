@extends('resources::livewire.layouts.main-layout')

@section('content')
    @empty($resource)
        <h2>No Resource</h2>
    @else

    <div class="mb-4 flex items-center">
        <div class="mr-4 hover:bg-neutral-dark p-2 rounded-full">
            <a href="{{ route('resources.home') }}">
                <x-heroicon-o-arrow-left class="h-6"/>
            </a>
        </div>
        <h1 class="py-2 text-3xl">Resource</h1>
    </div>
    <div class="xl:grid xl:grid-cols-9 xl:gap-9">
        <div class="xl:col-span-6">
            @if($resource->image)
                <div>
                    <img class="rounded-lg w-full object-cover max-h-96 bg-neutral-dark flex-shrink-0" src="{{$resource->image}}" alt="{{$resource->title}}">
                </div>
            @endif
            <div class="flex mt-6">
                <h3 class="text-dark-text-color text-4xl hover:underline font-bold">{{ $resource->title }}</h3>
                @empty(!$resource->is_verified)
                    <x-heroicon-o-check-circle class="flex-shrink-0 w-6 h-6 inline-block  text-green-700 text-xs font-medium rounded-full"/>
                @endempty
            </div>
            <div class="flex justify-start my-2">
                <x-heroicon-o-calendar class="w-5 h-5"/>
                <p class="ml-2 text-base-text-color text-md truncate">{{ $resource->created_at->format('M d, Y') }}</p>
            </div>
            @empty(!$resource->tags)
                <div class="flex justify-start space-x-2">
                    @foreach($resource->tags as $tag)
                        <x-library::tag>{{ $tag }}</x-library::tag>
                    @endforeach
                </div>
            @endempty

            <div class="text-xl my-6">
                {!! Purify::clean($resource->body) !!}
            </div>

            <div>
                <livewire:social::partials.post-actions wire:key="resource-actions-{{ $resource->id }}" :post="$resource"/>
            </div>

            @if($resource->url)
                <a href="{{ $resource->url }}" target="_blank" class="bg-primary hover:shadow-lg rounded-lg px-4 py-2 text-xl inline-flex items-center space-x-2">
                    <p>Go to website</p>
                    <x-heroicon-o-arrow-right class="h-6 w-6"/>
                </a>
            @endif

            <div class="py-4">
                @if ($resource->isParent())
                    <livewire:social::comment-section :post="$resource" :type="\Modules\Social\Enums\PostType::RESOURCE"/>
                @endif
            </div>

        </div>

        <aside class="hidden xl:block xl:col-span-3">
            <div class="sticky h-screen overflow-y-scroll scrollbar-hide top-4 space-y-4 pb-36 bg-primary shadow rounded-lg">
                <livewire:social::partials.trending-section title="Top Resources" type="resource"/>
                <livewire:social::partials.who-to-follow-section/>
                <livewire:social::partials.applications/>
            </div>
        </aside>

        <livewire:media-manager/>
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
