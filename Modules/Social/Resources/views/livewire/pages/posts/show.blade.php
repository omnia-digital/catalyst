@extends('social::livewire.layouts.main-layout')

@section('content')
<div class="divide-y">
    <livewire:social::components.post-card wire:key="post-{{ $post->id }}" :post="$post"/>

    <livewire:social::comment-section :post="$post"/>

    <livewire:media-manager/>
</div>
@endsection
