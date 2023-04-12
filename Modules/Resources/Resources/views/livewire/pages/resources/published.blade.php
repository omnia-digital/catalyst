@extends('social::livewire.layouts.pages.sidebar-page-layout')

@section('content')
    <div class="mb-3 rounded-b-lg pl-4 flex items-center bg-primary">
        <x-library::heading.1 class="py-4 hover:cursor-pointer">{{ Trans::get('Resources') }}</x-library::heading.1>
    </div>

    <div class="bg-secondary px-6 py-2 rounded-lg border-t border-b border-gray-100 sm:flex sm:items-center sm:justify-between">
        <nav class="flex space-x-8 py-2" aria-label="Global">
            <a href="{{ route('resources.home') }}" class="text-base-text-color hover:bg-neutral hover:text-base-text-color inline-flex items-center rounded-md py-2 px-3
            font-medium"
            >
                <x-library::icons.icon name="fa-regular fa-pen-to-square" size="w-5 h-5" class="pr-2"/>
                All Resources</a>
            <a href="{{ route('resources.drafts') }}" class="bg-neutral text-base-text-color inline-flex items-center rounded-md py-2 px-3 font-medium" aria-current="page">
                <x-library::icons.icon name="fa-duotone fa-newspaper" size="w-5 h-5" class="pr-2"/>
                My Resources</a>
        </nav>
    </div>

    <div class="bg-neutral px-6 py-1 border-t border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
        <nav class="flex space-x-8 py-2" aria-label="Global">
            <a href="{{ route('resources.drafts') }}" class="text-base-text-color hover:bg-white hover:text-base-text-color inline-flex items-center rounded-md py-2 px-3
            font-medium"
               >
                <x-library::icons.icon name="fa-regular fa-pen-to-square" size="w-5 h-5" class="pr-2"/>
                Drafts</a>
            <a href="{{ route('resources.published') }}" class="bg-white text-base-text-color inline-flex items-center rounded-md py-2 px-3 font-medium" aria-current="page">
                <x-library::icons.icon name="fa-duotone fa-newspaper" size="w-5 h-5" class="pr-2"/>
                Published</a>
        </nav>
    </div>



    <div class="mt-4">
        <div class="masonry sm:masonry-1 md:masonry-2">
            @forelse ($resources as $resource)
                <div class="w-full break-inside mb-3">
                    <div class="">
                        <livewire:resources::components.resource-card
                                as="li"
                                :post="$resource"
                                :wire:key="'resource-card-' . $resource->id"
                        />
                    </div>
                </div>
            @empty
                <p class="p-4 bg-secondary rounded-md text-base-text-color">No published resources yet.</p>
            @endforelse
        </div>

        <div class="pb-6">
            {{ $resources->onEachSide(1)->links() }}
        </div>
    </div>
@endsection
