@extends('crm::livewire.layouts.main-layout')

@section('full-width-header')
    @yield('full-width-header')
@endsection

@section('page-layout')
    <div class="flex">
        <div class="w-full">
            @yield('content')
        </div>
    </div>
@endsection
