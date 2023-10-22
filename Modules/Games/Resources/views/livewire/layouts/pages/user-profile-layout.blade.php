@extends('catalyst-social::livewire.layouts.main-layout')

@section('page-layout')
    <div class="flex space-x-4">
        <div class="mx-auto max-w-4xl w-full">
            @yield('content')
        </div>
        <x-sidebar-column class="max-w-sm"/>
    </div>
@endsection
