@extends('social::livewire.layouts.main-layout')


@section('content')
<div class="p-4">
    <div>
        <h1 class="text-2xl font-bold text-dark-text-color">Discover</h1>
    </div>
    <div>
        <div class="mt-2 space-y-2">
            @foreach ($posts as $post)
                <livewire:social::components.post-card :post="$post" />
            @endforeach
        </div>
    </div>
</div>
@endsection
