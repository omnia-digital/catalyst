@extends('jobs::livewire.layouts.main-layout')


@section('page-layout')
    <div class="grid grid-cols-12 gap-4 mr-4">
        <div class="col-span-9">
            @yield('content')
        </div>
        <x-sidebar-column class="hidden sm:block col-span-3"/>
    </div>
@endsection