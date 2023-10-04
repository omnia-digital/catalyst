@extends('social::livewire.layouts.pages.default-page-layout')

@section('banner-with-sidebar')
    <div class="w-full mb-4">
        <div class="relative shadow-xl sm:rounded-b-2xl sm:overflow-hidden">
            <div class="absolute inset-0 grayscale">
                <img class="h-full w-full object-cover"
                     src="https://source.unsplash.com/random"
                     alt="People working on laptops">
                <div class="absolute inset-0 bg-indigo-700 mix-blend-multiply"></div>
            </div>
            <div class="relative px-4 py-8 md:py-16 sm:px-6 sm:py-16 lg:py-16 lg:px-8">
                <x-library::heading.1 class="text-center uppercase"
                                      text-size="text-3xl md:text-5xl">{{ Translate::get('News Feeds') }}</x-library::heading.1>
                <p class="mt-2 md:mt-6 max-w-lg mx-auto text-center text-xl text-indigo-200 sm:max-w-3xl">Browse what's
                    happening right now.</p>
                </p>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="space-y-2">
        @foreach ($feeds as $feed)
            <livewire:feeds::feed-section :feed-url="$feed"/>
        @endforeach
    </div>
@endsection
