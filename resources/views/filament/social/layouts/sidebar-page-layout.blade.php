@extends('filament.social.layouts.main-layout')


@section('page-layout')
    <div class="grid grid-cols-12 gap-4 sm:mr-4">
        <div class="col-span-12 sm:col-span-8 2xl:col-span-9">
            @yield('banner-with-sidebar')
            <div class="ml-4 mr-4 lg:ml-0 sm:mr-0">
                @yield('content')
            </div>
        </div>
        <x-sidebar-column class="mt-4 hidden sm:block col-span-4 2xl:col-span-3"/>
    </div>
@endsection
