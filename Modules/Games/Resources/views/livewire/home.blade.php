@extends('games::livewire.layouts.pages.default-page-layout')

@section('content')
    <div wire:init="load" class="md:mr-4">
        <div class="sticky top-[55px] z-50 mb-4 rounded-b-lg pl-4 flex items-center bg-primary items-center">
            <div class="flex-1 flex items-center">
                <x-library::icons.icon name="fa-regular fa-gamepad-modern" color="text-secondary" class="h-8 w-8 mr-3"/>
                <x-library::heading.1 class="py-4">Games</x-library::heading.1>
            </div>
        </div>
        <div class="flex justify-between pt-2 space-x-4">
            <div class="w-full flex space-x-4">
                <livewire:games::components.search-dropdown/>
                <a href="https://www.igdb.com/" class="flex hover:underline items-center" target="_blank"><p class="text-sm text-neutral-dark flex items-center">powered by IGDB/Twitch</p></a>
            </div>
            <div class="flex w-1/4 space-x-2">
                <a href="https://www.igdb.com/games/new" class="w-1/2" target="_blank"><x-library::button class="w-full h-full">Add Game</x-library::button></a>
                <a href="https://www.igdb.com/companies/new" class="w-1/2" target="_blank"><x-library::button class="w-full h-full">Add Company</x-library::button></a>
            </div>
        </div>
            <div>
                <x-library::heading.2 class="my-6">Coming Soon</x-library::heading.2>
                <livewire:games::components.coming-soon/>
            </div>
{{--            <div>--}}
{{--                <h2 class="text-blue-500 uppercase tracking-wide font-semibold">Popular Games</h2>--}}
{{--                <livewire:games::components.popular-games/>--}}
{{--            </div>--}}
{{--            <div class="flex flex-col lg:flex-row my-10">--}}
{{--                <div class="recently-reviewed w-full lg:w-3/4 mr-0 lg:mr-4">--}}
{{--                    <h2 class="text-blue-500 uppercase tracking-wide font-semibold">Recently Reviewed</h2>--}}
{{--                    <livewire:games::components.recently-reviewed/>--}}
{{--                </div>--}}
{{--                <div class="most-anticipated lg:w-1/4 mt-12 lg:mt-0">--}}
{{--                    <h2 class="text-blue-500 uppercase tracking-wide font-semibold">Most Anticipated</h2>--}}
{{--                    <livewire:games::components.most-anticipated/>--}}

{{--                    <h2 class="text-blue-500 uppercase tracking-wide font-semibold mt-12">Coming Soon</h2>--}}
{{--                    <livewire:games::components.coming-soon/>--}}
{{--                </div> <!-- end most-anticipated -->--}}
{{--            </div>--}}
    </div>
@endsection
