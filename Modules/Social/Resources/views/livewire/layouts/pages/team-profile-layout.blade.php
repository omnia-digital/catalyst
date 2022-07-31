@extends('social::livewire.layouts.main-layout')

@section('full-width-header')
    <div class=" h-36 bg-[url('https://source.unsplash.com/random')] -mx-4 bg-cover bg-no-repeat"></div>
@endsection

@section('page-layout')
    <div class="flex space-x-4">
        <div class="w-full">
            <x-teams.partials.header :team="$team"/>
            @yield('content')
        </div>
    </div>
@endsection
