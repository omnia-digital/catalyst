@extends('social::livewire.layouts.main-layout')

@section('full-width-header')
    <div class="col-span-2 h-36 bg-[url('https://source.unsplash.com/random')] -mx-4 -mt-4 bg-cover bg-no-repeat"></div>
@endsection

@section('content')
<div>
    <div class="">
        <div class="">
            <div class="mb-2 flex justify-between items-center">
                <div class="flex-1 flex items-center">
                    <h1 class="py-2 text-3xl">My Projects <span class="bg-gray-400 text-xs rounded-full ml-2 p-1">24</span></h1>
                </div>

                <h2>

                <x-library::button x-data="" class="py-2 w-60 h-10">
                    Create Project
                </x-library::button>
                </h2>
            </div>
        </div>

        <!-- Filters -->
        @include('livewire.partials.filters')

        <!-- Initiatives -->
        <div class="mt-6">
            <div class="grid grid-cols-2 gap-4 lg:grid-cols-3 mt-4">
                @foreach ($projects as $project)
                    <div class="bg-primary border border-neutral-light rounded hover:scale-110 transition ease-in-out delay-150 duration-300">
                        <div class="h-36 rounded-t bg-[url('https://source.unsplash.com/random')] bg-cover bg-no-repeat"></div>
                        <div class="space-y-2 p-4">
                            <div class="flex justify-between">
                                <p class="text-dark-text-color font-semibold text-base">{{ $project->title }}</p>
                                <div class="flex items-center">
                                    <x-heroicon-o-users class="h-4 w-4 mr-2" />
                                    <p>{{ $project->users()->count() }}</p>
                                </div>
                            </div>
                            <div class="flex items-center text-base-text-color">
                                <x-heroicon-o-location-marker class="h-5 w-5 mr-2" />
                                <span class="text-dark-text-color text-xs">Jacksonville, Florida, USA</span>
                            </div>
                            <p class="text-light-text-color text-xs line-clamp-3">{{ $project->summary }}</p>
                            <div class="text-base-text-color text-xs flex items-center space-x-4 pt-6">
                                <div class="flex items-center">
                                    <x-heroicon-o-calendar class="h-4 w-4 mr-2" />
                                    <p>{{ $project->launch_date->toFormattedDateString() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
