@extends('jobs::livewire.layouts.main-layout')


@section('page-layout')
    <div class="grid grid-cols-12 gap-4 sm:mr-4">
        <div class="col-span-12 sm:col-span-8 2xl:col-span-9">
            @yield('banner-with-sidebar')
            <div class="mx-4 sm:ml-4 sm:mr-0">
                @yield('content')
            </div>
        </div>
        <x-sidebar-column class="hidden sm:block col-span-3"/>
    </div>
@endsection
