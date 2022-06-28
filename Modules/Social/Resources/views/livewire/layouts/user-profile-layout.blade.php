@extends('social::livewire.layouts.main-layout')


@section('content')
    <div class="flex space-x-4">
        <div class="mx-auto max-w-4xl w-full">
            @yield('main-content')
        </div>
        <x-sidebar-column class="max-w-sm"/>
    </div>
@endsection
