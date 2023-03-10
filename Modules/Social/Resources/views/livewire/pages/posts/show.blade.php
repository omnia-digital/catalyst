@extends('social::livewire.layouts.pages.default-page-layout')

@section('content')
    <div class="flex">
        <div class="mt-6 mr-4 w-8">
            <div class="hover:bg-neutral-light p-2 rounded-full bg-secondary hover:text-secondary flex justify-center items-center">
                <a href="{{ route('social.home') }}">
                    <x-heroicon-o-arrow-left class="h-4"/>
                </a>
            </div>
        </div>
        <div class="mt-6 max-w-post-card-max-w mx-auto divide-y">
            <livewire:social::components.post-card wire:key="post-{{ $post->id }}" :post="$post" :clickable="false"/>
    
            @auth
                <livewire:social::comment-section :post="$post"/>
                <livewire:media-manager/>
            @endauth
        </div>
    </div>

    <livewire:authentication-modal/>
@endsection
