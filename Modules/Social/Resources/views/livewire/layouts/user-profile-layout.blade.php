@extends('social::livewire.layouts.two-column-layout')

@section('main-content')
    @yield('content')
@endsection

@section('sidebar')
    <x-sidebar-column class="max-w-sm"/>
@endsection

