@extends('resources::livewire.layouts.main-layout')


@section('page-layout')
    <div class="flex space-x-4 pt-6">
        <div class="w-full">
            @yield('content')
        </div>
    </div>
@endsection
