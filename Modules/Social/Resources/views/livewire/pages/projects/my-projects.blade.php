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
                    <livewire:social::components.project-card :project="$project" />
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
