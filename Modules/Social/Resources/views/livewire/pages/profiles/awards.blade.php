@extends('social::livewire.layouts.pages.user-profile-layout')

@section('content')
    <div class="mt-4 -ml-4">
        <h2 class="text-black font-semibold text-2xl">Awards</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
            @foreach ($profile->awards as $award)
                <x-awards-banner :award="$award"/>
            @endforeach
        </div>
    </div>
@endsection
