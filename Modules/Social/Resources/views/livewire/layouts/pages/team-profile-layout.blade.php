@extends('social::livewire.layouts.main-layout')

@section('page-layout')
    <div class="flex space-x-4">
        <div class="w-full">
            <x-teams.partials.header :team="$team"/>
            @yield('content')
        </div>
    </div>
@endsection
