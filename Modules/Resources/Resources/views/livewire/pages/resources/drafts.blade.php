@extends('resources::livewire.layouts.pages.sidebar-page-layout')

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
                <x-library::heading.1 class="text-center uppercase" text-size="text-5xl">{{ Trans::get('My Resources') }}</x-library::heading.1>
                <div class="mt-10 max-w-sm mx-auto sm:max-w-none sm:flex sm:justify-center">
                    <div class="justify-center w-full flex md:w-1/2 lg:w-1/3">
                        <x-library::button.link
                            href="{{ route('resources.create') }}"
                            class="py-2 w-full h-10"
                        >+ New Resource</x-library::button.link>
                        <livewire:resources::pages.resources.create/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-secondary px-6 py-2 rounded-lg border-t border-b border-gray-100 sm:flex sm:items-center sm:justify-between">
        <nav class="flex space-x-8 py-2" aria-label="Global">
            <a href="{{ route('resources.drafts') }}" class="bg-neutral text-base-text-color inline-flex items-center rounded-md py-2 px-3 font-medium"
               aria-current="page">
                <x-library::icons.icon name="fa-regular fa-pen-to-square" size="w-5 h-5" class="pr-2"/>Drafts</a>
            <a href="{{ route('resources.published') }}" class="text-base-text-color hover:bg-neutral hover:text-base-text-color inline-flex items-center rounded-md py-2 px-3
            font-medium">
                <x-library::icons.icon name="fa-duotone fa-newspaper" size="w-5 h-5" class="pr-2"/>Published</a>
        </nav>
    </div>

    <div class="mt-4">
        <div class="masonry sm:masonry-1 md:masonry-2">
            @forelse($resources as $resource)
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
                <li class="p-4 bg-secondary rounded-md text-base-text-color">No resources to show</li>
            @endforelse
        </div>

        <div class="pb-6">
            {{ $resources->onEachSide(1)->links() }}
        </div>
    </div>
@endsection
