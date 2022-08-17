@extends('social::livewire.layouts.pages.default-page-layout')


@section('content')
    <div class="sticky top-[55px] z-40 mb-4 rounded-b-lg pl-4 flex items-center bg-secondary items-center">
        <div class="flex-1 flex items-center">
            <x-dynamic-component component="heroicon-o-collection"
                                 class="{{ 'text-primary' }} mr-3 flex-shrink-0 h-8 w-8"
                                 aria-hidden="true"/>
            <h1 class="py-4 text-3xl text-primary hover:cursor-pointer">{{ Trans::get('Trending') }}</h1>
        </div>
    </div>
    <div>
        <div class="mt-2 space-y-2">
            @foreach ($posts as $post)
                <livewire:social::components.post-card :post="$post"/>
            @endforeach
        </div>
    </div>
@endsection
