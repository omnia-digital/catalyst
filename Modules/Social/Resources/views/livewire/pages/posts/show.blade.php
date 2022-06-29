@extends('social::livewire.layouts.pages.default-page-layout')

@section('content')
    <div class="flex space-x-6">

        <div class="divide-y">
            <livewire:social::components.post-card wire:key="post-{{ $post->id }}" :post="$post" :clickable="false"/>

            <livewire:social::comment-section :post="$post"/>

        </div>
        <x-sidebar-column class="max-w-sm" post-type="resource"/>
    </div>

    <livewire:media-manager/>
@endsection
