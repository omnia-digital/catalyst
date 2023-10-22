@extends('catalyst-social::livewire.layouts.main-layout')


@section('page-layout')
    <div class="flex space-x-4 mr-4">
        <div class="w-full">
            @yield('content')
        </div>
    </div>
@endsection
