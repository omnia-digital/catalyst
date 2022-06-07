@extends('social::livewire.layouts.main-layout')


@section('content')
<div class="-mx-4">
    <div class="h-60 bg-[url('https://source.unsplash.com/random')] bg-cover bg-no-repeat relative overlay before:bg-black before:inset-0 before:opacity-60">
        <div class="mb-1 mx-[15px] absolute bottom-0 left-0 right-0 flex justify-between items-end">
            <div class="flex items-end">
                <div class="mr-3 z-10 -mb-12">
                    <img class="h-24 w-24 rounded-full" src="{{ $this->owner->profile_photo_url }}" alt="{{ $this->owner->name }}" />
                </div>
                <div>
                    <h1 class="text-3xl text-white">{{ $project->name  }}</h1>
                    <p class="text-sm text-white">{{ '@' .  $this->owner->handle }}</p>
                </div>
            </div>
            {{-- No program to calculate reviwScore yet
                <div class="flex items-center text-white text-3xl font-semibold">
                <x-heroicon-s-star class="w-6 h-6" />
                {{ $this->owner->reviewScore ?? '3758' }}
            </div> --}}
        </div>
    </div>
    <x-teams.overview-navigation class="bg-gray-300" :team="$project" />
</div>
<div class="mt-4 -mx-4">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mt-4">
        @foreach ($project->followers as $item)
            <livewire:social::user-tile :user="$item->followable"  />
        @endforeach
    </div>
</div>
@endsection
