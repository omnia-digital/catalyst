@extends('social::livewire.layouts.pages.default-page-layout')

@section('content')
        <div class="divide-y">
            <livewire:social::components.post-card wire:key="post-{{ $post->id }}" :post="$post" :clickable="false"/>

            <livewire:social::comment-section :post="$post"/>

        </div>
    <livewire:media-manager/>
@endsection
