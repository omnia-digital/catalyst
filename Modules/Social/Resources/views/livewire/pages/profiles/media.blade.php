@extends('social::livewire.layouts.user-profile-layout')


@section('main-content')
<div x-data="{ open : false, imageSrc : '' }">
    <x-profiles.partials.header :user="$this->user" />
    <div class="mt-4 -ml-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mt-4">
            @foreach ($media as $mediaItem)
                <div x-on:click="open = true; imageSrc = '{{ $mediaItem->getFullUrl() }}';"
                    class="border border-neutral-light rounded-md group relative bg-secondary hover:cursor-pointer hover:ring-1 hover:ring-secondary"
                    style="background-image: url({{ $mediaItem->getFullUrl() }}); background-size: cover; background-repeat: no-repeat;"
                >
                    <div class="h-40 rounded-md"></div>
                </div>
            @endforeach
        </div>
    </div>
    <div
        x-show="open"
        x-cloak
        x-on:keydown.escape.prevent.stop="open = false"
        class="fixed inset-0 overflow-y-auto z-[900]"
    >
        <!-- Overlay -->
        <div x-show="open" x-transition class="fixed inset-0 bg-gray-400/75"></div>

        <div
            x-show="open"
            x-transition
            @click.away="imageSrc"
            class="relative min-h-screen flex items-center justify-center p-4"
        >
            <div @click.away="open = false" class="flex flex-col max-w-3xl max-h-full overflow-auto">
                <div class="p-2">
                    <img :alt="imageSrc" class="object-contain h-1/2-screen" :src="imageSrc">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
