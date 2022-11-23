@extends('social::livewire.layouts.pages.default-page-layout')


@section('content')
    <div class="sticky top-[55px] z-40 mb-4 rounded-b-lg pl-4 flex items-center bg-primary items-center">
        <div class="flex-1 flex items-center">
{{--            <x-library::icons.icon name="heroicon-o-collection" color="text-secondary" class="h-8 w-8 mr-3"/>--}}
            <x-library::heading.1 class="py-4 hover:cursor-pointer">{{ Trans::get('Trending') }}</x-library::heading.1>
        </div>
    </div>
    <div class="grid grid-cols-7 gap-6">
        <div class="col-span-4">
            <x-library::heading.2>{{ Trans::get('Posts') }}</x-library::heading.2>
            <div class="mt-2 space-y-2">
                @foreach ($posts as $post)
                    <livewire:social::components.post-card :post="$post" :show-post-actions="false"/>
                @endforeach
            </div>
        </div>
        <div class="col-span-3">
            <x-library::heading.2>{{ Trans::get('Profiles') }}</x-library::heading.2>
            <div class="grid grid-cols-2 w-full gap-2">
                @foreach ($profiles as $profile)
                    <x-user-tile :user="$profile->user"/>
                @endforeach
            </div>
        </div>
    </div>
@endsection
