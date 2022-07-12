@extends('games::livewire.layouts.pages.default-page-layout')

@section('content')
    <div class="container mx-auto px-4">
        <h2 class="text-blue-500 uppercase tracking-wide font-semibold">Popular Games</h2>
{{--        <livewire:games::components.popular-games/>--}}

        @foreach($games as $game)
            <div>
                {{ $game->name }}
            </div>
        @endforeach
        <div class="flex falex-col lg:flex-row my-10">
            <div class="recently-reviewed w-full lg:w-3/4 mr-0 lg:mr-32">
                <h2 class="text-blue-500 uppercase tracking-wide font-semibold">Recently Reviewed</h2>
                {{--                    <livewire:games::components.recently-reviewed/>--}}
            </div>
            <div class="most-anticipated lg:w-1/4 mt-12 lg:mt-0">
                <h2 class="text-blue-500 uppercase tracking-wide font-semibold">Most Anticipated</h2>
                {{--                    <livewire:games::components.most-anticipated/>--}}

                <h2 class="text-blue-500 uppercase tracking-wide font-semibold mt-12">Coming Soon</h2>
                {{--                        <livewire:games::components.coming-soon/>--}}
            </div> <!-- end most-anticipated -->
        </div>
    </div> <!-- end container -->
@endsection