@extends('social::livewire.layouts.pages.full-page-layout')

@section('content')
    <div class="p-4">
        <x-library::heading.1>Art</x-library::heading.1>
        <div class="grid grid-cols-3">
            @foreach($media_items as $media)
                @if($media->image)
                    <img src="{{ $media->image }}"/>
                @else
                    {{ $media }}
                @endif
            @endforeach
        </div>
    </div>
@endsection
