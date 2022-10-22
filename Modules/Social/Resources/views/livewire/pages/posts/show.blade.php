@extends('social::livewire.layouts.pages.default-page-layout')

@section('content')
    <div class="mt-6 max-w-post-card-max-w mx-auto divide-y">
        <livewire:social::components.post-card wire:key="post-{{ $post->id }}" :post="$post" :clickable="false"/>

        @auth
            <livewire:social::comment-section :post="$post"/>
            <livewire:media-manager/>
        @endauth
    </div>
@endsection
