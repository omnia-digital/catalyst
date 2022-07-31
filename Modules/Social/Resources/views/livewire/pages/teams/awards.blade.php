@extends('social::livewire.layouts.pages.team-profile-layout')

@section('content')
    <div class="mt-4">
        <h2 class="text-base-text-color font-semibold text-2xl">Awards</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mt-4">
            @foreach ($team->awards as $award)
                <x-awards-banner :award="$award"/>
            @endforeach
        </div>
    </div>
@endsection
