@extends('social::livewire.layouts.pages.default-page-layout')


@section('content')
        <div>
            <x-library::heading.2 boldClass="py-2 text-3xl">Trending</x-library::heading.2>
        </div>
        <div>
            <div class="mt-2 space-y-2">
                @foreach ($posts as $post)
                    <livewire:social::components.post-card :post="$post"/>
                @endforeach
            </div>
        </div>
@endsection
